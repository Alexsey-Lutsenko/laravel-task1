import {createWebHistory, createRouter} from "vue-router";
import HomePage from "../../views/page/HomePage";
import AdminPage from "../../views/page/AdminPage";

const routes = [
    {
        path: '/',
        name: HomePage,
        component: HomePage,
    },
    {
        path: '/admin',
        name: AdminPage,
        component: AdminPage
    }
]

const router = createRouter({
    routes,
    history: createWebHistory(process.env.BASE_URL)
})

export default router
