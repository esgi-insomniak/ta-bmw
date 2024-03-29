<script setup>
import { ref, onMounted } from 'vue'
import carService from '../services/car.service';
import GarageService from '../services/garage.service';
import GarageSchudleEventService from '../services/schudle.service.js';
import UserService from '../services/user.service.js';
import moment from 'moment/dist/moment';
import fr from 'moment/dist/locale/fr';
//import { generateICalendar } from '../helpers/index.js';
//import QRCode from 'qrcode';
moment.locale('fr', fr);
const questions = ref([
    {
        label: 'Pour quelle raison souhaitez vous prendre RDV ?', type: 'radio', options: [
            { label: 'Révision', value: 'revision', id: 1 },
            { label: 'Réparation', value: 'reparation', id: 2 },
            { label: 'Vidange', value: 'vidange', id: 3 },
            { label: 'Autre', value: 'autre', id: 4 },
        ], step: 1, name: 'reason'
    },
    {
        label: 'Quel est le modèle de votre véhicule ?', type: 'select', step: 2, options: [], name: 'model'
    },
    { label: 'Quel est le kilométrage de votre véhicule ?', type: 'number', step: 3, name: 'kilometrage' },
    {
        label: 'Quel est le type de carburant de votre véhicule ?', type: 'radio', options: [
            { label: 'Essence', value: 'essence', id: 1 },
            { label: 'Diesel', value: 'diesel', id: 2 },
            { label: 'Hybride', value: 'hybride', id: 5 },
            { label: 'Electrique', value: 'electrique', id: 6 },
        ], step: 4, name: 'fuel'
    },
    {
        label: 'Quel est le type de boite de vitesse de votre véhicule ?', type: 'radio', options: [
            { label: 'Manuelle', value: 'manuelle', id: 1 },
            { label: 'Automatique', value: 'automatique', id: 2 },
        ], step: 5, name: 'gearbox'
    },
    {
        label: 'Choisissez votre concession', type: 'select', options: [], step: 6, name: 'concession'
    },
    { label: 'Selectionnez un créneau qui vous convient:', type: 'select', options: [], dataComplete: true, step: 7, name: 'appointement' }
])
const answers = ref([])
const currentQuestion = ref(1)
const nextQuestion = (userChoice) => {
    if (currentQuestion.value === 6) {
        Promise.resolve().then(() => {
            getGaragesEvents(userChoice.concession);
        });
    } else if (currentQuestion.value === questions.value.length) {
        Promise.resolve().then(() => {
            sendFormData()
            // .then(() => {
            //     const ics = generateICalendar({
            //         title: 'Rendez-vous chez votre concessionnaire',
            //         description: 'Rendez-vous chez votre concessionnaire',
            //         location: 'ICI C\'EST PARIS',
            //         start: moment(answers.value[6].appointement).set('minute', 0).set('second', 0).set('millisecond', 0).toISOString(),
            //         end: moment(answers.value[6].appointement).set('minute', 0).set('second', 0).set('millisecond', 0).add(1, 'hour').toISOString(),
            //     })
            //     const blob = new Blob([ics], { type: 'text/calendar;charset=utf-8' });
            //     // QRCode.toCanvas(document.getElementById('calendar'), URL.createObjectURL(blob), { width: 200 }, function (error) {
            //     //     if (error) console.error(error)
            //     //     console.log('success!');
            //     // })
            //     const link = document.createElement('a');
            //     link.href = URL.createObjectURL(blob);
            //     link.download = 'calendar.ics';
            //     link.click();
            // })
        })
    }
    answers.value.push(userChoice)
    currentQuestion.value++
}
const previousQuestion = (e) => {
    e.preventDefault()
    currentQuestion.value--
}

const getGaragesEvents = async (concessionId) => {
    const fromDate = moment().add(1, 'days').startOf('day');
    const toDate = moment().add(7, 'days').startOf('day');
    const disponibilities = await GarageSchudleEventService.getCalendarDisponibilities(concessionId, fromDate, toDate);

    questions.value[6].options = disponibilities.reduce((acc, day) => {
        return [...acc, ...day.disponibilities]
    }, []).filter(dispo => dispo.isDisponible).map(dispo => {
        return { label: dispo.label, value: dispo.start }
    })
}

const sendFormData = async () => {
    const user = await UserService.get('me');
    const garageSchudleEvent = {
        dateStart: moment(answers.value[6].appointement).set('minute', 0).set('second', 0).set('millisecond', 0).toISOString(),
        dateEnd: moment(answers.value[6].appointement).add(2, 'hours').set('minute', 0).set('second', 0).set('millisecond', 0).toISOString(),
        associateGarage: `garages/${answers.value[5].concession}`,
        associateUser: `users/${user.id}`,
        reason: answers.value[0].reason,
        carIdentity: `car_identities/${answers.value[1].model}`,
        kilometers: answers.value[2].kilometrage,
        fuel: answers.value[3].fuel,
        gearbox: answers.value[4].gearbox,
        type: 'demande-de-service'
    };
    await GarageSchudleEventService.post(garageSchudleEvent);
}

onMounted(async () => {
    const models = await carService.getCarIdentityCollection()
    questions.value[1].options = models.map(model => {
        return { label: model.name, value: model.id }
    })
    const garages = await GarageService.getCollection({ itemsPerPage: 50 })
    questions.value[5].options = garages.map(garage => {
        return { label: garage.name, value: garage.id }
    })
})
</script>

<template>
    <div class="h-[88vh] w-full flex justify-center items-center">
        <div class="flex flex-col h-full overflow-scroll justify-center items-center w-[70vw] relative"
            v-if="currentQuestion < questions.length + 1">
            <div class="absolute top-16 flex items-center justify-start w-full space-x-5">
                <button @click="previousQuestion" v-if="currentQuestion !== 1" class="left-56">
                    Question précédente
                </button>
                <span class="font-bold text-xl">
                    Etape {{ currentQuestion }}/{{ questions.length }}
                </span>
            </div>
            <FormKit type="form" @submit="nextQuestion" form-class="w-full"
                :submit-label="currentQuestion === questions.length ? 'Demande de RDV' : 'Question suivante'">
                <template v-for="question in questions">
                    <FormKit :type="question.type" :name="question.name" :label="question.label"
                        :options="question.options" v-if="question.step === currentQuestion" validation="required"
                        :validation-messages="{
                            required: 'Ce champs est requis ! ❌'
                        }" />
                </template>
            </FormKit>
        </div>
        <div v-else class="text-green-500">
            Votre demande à bien été prise en compte, retrouver votre rendez-vous sur votre profil.
            <div id="calendar" ref="calendar"></div>
        </div>
    </div>

</template>