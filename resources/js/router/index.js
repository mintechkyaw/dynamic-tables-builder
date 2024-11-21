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
            component: LoginPage,
        },
        {
            path: "/",
            component: DashboardPage,
            children:[
                {
                    name: "",
                    path:"",
                    component: HomePage,

                },
                {
                    path:"/forms",
                    component: FormsPage,
                },
                {
                    path:"/tables",
                    component:TablesPage,
                },
                {
                    path:"tables/:id",
                    component: TableSubmitPage,
                }
            ]
        }
    ],
});

export default router;
