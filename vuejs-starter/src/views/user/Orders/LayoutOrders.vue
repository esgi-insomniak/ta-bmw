<script setup>
import { useRoute } from 'vue-router';
const route = useRoute();
</script>
<template>
    <div class="flex w-full h-[88vh]">
        <div class="w-1/4 h-full flex flex-col items-center justify-start pt-5 space-y-5">
            <div class="text-left min-w-[10rem]">
                <details :open="route.path.startsWith('/me/list/orders')"
                    class="text-left min-w-[10rem] group overflow-hidden max-h-[56px] open:!max-h-[400px] transition-[max-height] duration-500">
                    <summary
                        class="outline-none cursor-pointer focus:text-white marker:text-transparent group-open:before:rotate-90  before:origin-center relative before:w-[18px] before:h-[18px] before:transition-transform before:duration-200 before:-left-1 before:top-2/4 before:-translate-y-2/4 before:absolute before:bg-no-repeat before:bg-[length:18px_18px] before:bg-center before:bg-[url('data:image/svg+xml,%3Csvg%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20class%3D%22h-6%20w-6%22%20fill%3D%22none%22%20viewBox%3D%220%200%2024%2024%22%20stroke%3D%22white%22%20stroke-width%3D%222%22%3E%0A%20%20%3Cpath%20stroke-linecap%3D%22round%22%20stroke-linejoin%3D%22round%22%20d%3D%22M9%205l7%207-7%207%22%20%2F%3E%0A%3C%2Fsvg%3E')]">
                        Mes commandes</summary>
                    <ul class="px-4">
                        <li>
                            <router-link to="/me/list/orders/all"
                                :class="route.path === '/me/list/orders/all' ? 'font-bold scale-110' : 'hover:scale-110 hover:font-bold'"
                                class="cursor-pointer text-left min-w-[10rem]">
                                Toutes
                            </router-link>
                        </li>
                        <li>
                            <router-link to="/me/list/orders/in-progress"
                                :class="route.path === '/me/list/orders/in-progress' ? 'font-bold scale-110' : 'hover:scale-110 hover:font-bold'"
                                class="cursor-pointer text-left min-w-[10rem]">
                                En cours
                            </router-link>
                        </li>
                        <li>
                            <router-link to="/me/list/orders/completed"
                                :class="route.path === '/me/list/orders/finished' ? 'font-bold scale-110' : 'hover:scale-110 hover:font-bold'"
                                class="cursor-pointer text-left min-w-[10rem]">
                                Terminées
                            </router-link>
                        </li>
                        <li>
                            <router-link to="/me/list/orders/canceled"
                                :class="route.path === '/me/list/orders/finished' ? 'font-bold scale-110' : 'hover:scale-110 hover:font-bold'"
                                class="cursor-pointer text-left min-w-[10rem]">
                                Annulées
                            </router-link>
                        </li>
                    </ul>
                </details>
                <details :open="route.path.startsWith('/me/list/sales')"
                    class="text-left min-w-[10rem] group overflow-hidden max-h-[56px] open:!max-h-[400px] transition-[max-height] duration-500">
                    <summary
                        class="outline-none cursor-pointer focus:text-white marker:text-transparent group-open:before:rotate-90  before:origin-center relative before:w-[18px] before:h-[18px] before:transition-transform before:duration-200 before:-left-1 before:top-2/4 before:-translate-y-2/4 before:absolute before:bg-no-repeat before:bg-[length:18px_18px] before:bg-center before:bg-[url('data:image/svg+xml,%3Csvg%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20class%3D%22h-6%20w-6%22%20fill%3D%22none%22%20viewBox%3D%220%200%2024%2024%22%20stroke%3D%22white%22%20stroke-width%3D%222%22%3E%0A%20%20%3Cpath%20stroke-linecap%3D%22round%22%20stroke-linejoin%3D%22round%22%20d%3D%22M9%205l7%207-7%207%22%20%2F%3E%0A%3C%2Fsvg%3E')]">
                        Mes ventes</summary>
                    <ul class="px-4">
                        <li>
                            <router-link to="/me/list/sales"
                                :class="route.path === '/me/list/sales' ? 'font-bold scale-110' : 'hover:scale-110 hover:font-bold'"
                                class="cursor-pointer text-left min-w-[10rem]">
                                Nouvelle vente
                            </router-link>
                        </li>
                        <li>
                            <router-link to="/me/list/sales/all"
                                :class="route.path === '/me/list/sales/all' ? 'font-bold scale-110' : 'hover:scale-110 hover:font-bold'"
                                class="cursor-pointer text-left min-w-[10rem]">
                                Toutes
                            </router-link>
                        </li>
                        <li>
                            <router-link to="/me/list/sales/in-progress"
                                :class="route.path === '/me/list/sales/in-progress' ? 'font-bold scale-110' : 'hover:scale-110 hover:font-bold'"
                                class="cursor-pointer text-left min-w-[10rem]">
                                En cours
                            </router-link>
                        </li>
                        <li>
                            <router-link to="/me/list/sales/completed"
                                :class="route.path === '/me/list/sales/finished' ? 'font-bold scale-110' : 'hover:scale-110 hover:font-bold'"
                                class="cursor-pointer text-left min-w-[10rem]">
                                Terminées
                            </router-link>
                        </li>
                        <li>
                            <router-link to="/me/list/sales/canceled"
                                :class="route.path === '/me/list/orders/finished' ? 'font-bold scale-110' : 'hover:scale-110 hover:font-bold'"
                                class="cursor-pointer text-left min-w-[10rem]">
                                Annulées
                            </router-link>
                        </li>
                    </ul>
                </details>
            </div>
        </div>
        <div class="pr-24 pl-32 py-10 w-full">
            <router-view />
        </div>
    </div>
</template>


