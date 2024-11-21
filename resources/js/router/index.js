import { createRouter, createWebHistory } from "vue-router";
import LoginPage from "../pages/auth/Login.page.vue";
import DashboardPage from "../pages/admin/Dashboard.page.vue";
import HomePage from "../pages/admin/HomePage.vue";
import FormsPage from "../pages/admin/FormsPage.vue";
import TablesPage from "../pages/admin/TablesPage.vue";
import TableSubmitPage from "../pages/admin/TableSubmitPage.vue";

const router = createRouter({
    history: createWebHistory(),
    routes: [
        {
            path: "/login",
            name: "LoginPage",
            component: LoginPage,
        },
        {
            path: "/",
            component: DashboardPage,
            meta: { requiresAuth: true },
            children: [
                {
                    name: "HomePage",
                    path: "",
                    component: HomePage,
                },
                {
                    path: "/forms",
                    component: FormsPage,
                },
                {
                    path: "/tables",
                    component: TablesPage,
                },
                {
                    path: "tables/:id",
                    component: TableSubmitPage,
                },
            ],
        },
    ],
});

router.beforeEach((to, from, next) => {
    const token = localStorage.getItem("token");

    if (to.matched.some((record) => record.meta.requiresAuth)) {
        if (!token) {
            next("/login");
        } else {
            next(); // Proceed to the route
        }
    } else if (to.name === "LoginPage" && token) {
        next("/");
    } else {
        next();
    }
});

export default router;
