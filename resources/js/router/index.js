import { createRouter, createWebHistory } from "vue-router";
import LoginPage from "../pages/auth/Login.page.vue";
import DashboardPage from "../pages/admin/Dashboard.page.vue";
import HomePage from "../pages/admin/HomePage.vue";
import FormsPage from "../pages/admin/FormsPage.vue";
import TablesPage from "../pages/admin/TablesPage.vue";
import TableSubmitPage from "../pages/admin/TableSubmitPage.vue";
import FormFieldPage from "../pages/admin/FormFieldPage.vue";
import DetailsPage from "../pages/admin/DetailsPage.vue";
import ResponseTableLists from "../components/ResponseTableLists.vue";
import UserCreatePage from "../pages/admin/UserCreatePage.vue";
import UserListPage from "../pages/admin/UserListPage.vue";
import RolePage from "../pages/admin/RolePage.vue";

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
                    name: "FormPage",
                    path: "/forms",
                    component: FormsPage,
                },
                {
                    name: "TablesPage",
                    path: "/tables",
                    component: TablesPage,
                },
                {
                    name: "TableSubmitPage",
                    path: "tables/:id",
                    component: TableSubmitPage,
                },
                {
                    name: "FormFieldPage",
                    path: "/form_field/:id",
                    component: FormFieldPage,
                },
                {
                    name:"DetailsPage",
                    path:"/details/:id",
                    component: DetailsPage,
                },
                {
                    name:"ResponseTableLists",
                    path:"/responseTableLists/:id",
                    component: ResponseTableLists,
                },
                {
                    name:"UserCreatePage",
                    path:"/user-create",
                    component : UserCreatePage
                },
                {
                    name : "UserListPage",
                    path : "/user-list",
                    component : UserListPage
                },
                {
                    name : "RolePage",
                    path : "/role",
                    component : RolePage
                }
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
