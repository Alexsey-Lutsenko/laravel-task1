import { createWebHistory, createRouter } from "vue-router";
import AdminPage from "../views/pages/AdminPage";
import AuthPage from "../views/pages/AuthPage";
import store from "../store";
import NotFound from "../views/pages/NotFound";
import FertilizerPage from "../views/pages/FertilizerPage";
import ClientPage from "../views/pages/ClientPage";
import CulturePage from "../views/pages/CulturePage";
import UserPage from "../views/pages/UserPage";
import DeletedPage from "../views/pages/DeletedPage";
import UserDeleted from "../components/deletedComponent/UserDeleted";
import ClientDeleted from "../components/deletedComponent/ClientDeleted";
import CultureDeleted from "../components/deletedComponent/CultureDeleted";
import FertilizerDeleted from "../components/deletedComponent/FertilizerDeleted";

const routes = [
    {
        path: "/",
        name: AdminPage,
        component: AdminPage,
        meta: {
            layout: "admin",
            auth: true,
        },
        children: [
            {
                path: "/",
                redirect: "/client",
            },
            {
                path: "/client",
                name: ClientPage,
                component: ClientPage,
            },
            {
                path: "/culture",
                name: CulturePage,
                component: CulturePage,
            },
            {
                path: "/fertilizer",
                name: FertilizerPage,
                component: FertilizerPage,
            },
            {
                path: "/user",
                name: UserPage,
                component: UserPage,
            },
            {
                path: "/deleted",
                name: DeletedPage,
                component: DeletedPage,
            },
        ],
    },
    {
        path: "/auth",
        name: AuthPage,
        component: AuthPage,
        meta: {
            layout: "main",
            auth: false,
        },
    },
    {
        path: "/:notFound(.*)",
        name: NotFound,
        component: NotFound,
        meta: {
            layout: "main",
            auth: true,
        },
    },
];

const router = createRouter({
    routes,
    history: createWebHistory(process.env.BASE_URL),
    linkActiveClass: "active",
    linkExactActiveClass: "active",
});

router.beforeEach((to, from, next) => {
    const requireAuth = to.meta.auth;

    if (requireAuth && store.getters["auth/isAuthenticated"]) {
        next();
    } else if (requireAuth && !store.getters["auth/isAuthenticated"]) {
        next("/auth?message=auth");
    } else if (!requireAuth && store.getters["auth/isAuthenticated"]) {
        next("/");
    } else {
        next();
    }
});

export default router;
