<script setup>
import { ref, computed, onMounted } from 'vue'
import { useStore } from "vuex";
import { useRouter } from "vue-router";

const props = defineProps({
  email: {
    type: String,
  },
  password: {
    type: String,
  }
})

const email = ref('')
const password = ref('')
const store = useStore();
const router = useRouter();

const isDisabled = computed(() => {
  return email.value.length === 0 || password.value.length === 0
});

const loggedIn = computed(() => {
  return store.getters['auth/loggedIn'];
});

const handleLogin = () => {
  store.dispatch('auth/login', { email: email.value, password: password.value }).then(() => {
    router.push('/home');
  })
    .catch((error) => {
      console.log(error);
    });
}

const handleForgotPassword = () => {
  router.push('/forgot_password');
}

onMounted(() => {
  if (loggedIn.value) {
    router.push('/home');
  }
});

</script>

<template>
  <div class="flex justify-center items-center h-[88vh]">
    <div class="w-2/3 h-4/6 rounded-3xl shadow-md bg-white/30 flex">
      <div class="w-1/3 bg-[url('/public/bg_login.jpg')] bg-cover rounded-l-3xl" />
      <div class="w-2/3 flex flex-col justify-center items-center px-2">
        <FormKit type="form" form-class="w-full flex justify-center  flex-col h-4/6" @submit="handleLogin"
          submit-label="Connexion">
          <FormKit type="text" name="email" label="Email" placeholder="exemple@email.here" validation="required|email"
            v-model="email" />
          <FormKit type="password" name="password" label="Password" placeholder="Mot de passe"
            validation="required|password" v-model="password" />
        </FormKit>
        <div class="text-white hover:text-blue-500 hover:underline hover:cursor-pointer" @click="handleForgotPassword">
          Mot de passe oublié ?
        </div>
        <div class="text-white hover:text-blue-500 hover:underline hover:cursor-pointer"
          @click="router.push({ name: 'register' })">
          Créer un compte
        </div>
      </div>
    </div>
  </div>
</template>