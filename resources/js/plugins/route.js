import { createWebHistory, createRouter } from "vue-router";
import DashboardLayout from '../layouts/dashboard-layout';
import WebLayout from '../layouts/web/web-layout';
import Register from '../components/web/auth/register';
import Login from '../components/web/auth/login';
import ForgetPassword from '../components/web/auth/forget-password';
import ResetPassword from '../components/web/auth/reset-password';
import EmailVerification from '../components/web/auth/email-verification';
import Profile from '../components/web/auth/profile';
import UserBlogs from '../components/web/blog/user-blogs';
import Blogs from '../components/web/blog/blogs';
import BlogDetails from '../components/web/blog/blog-details';
import BlogCreate from '../components/web/blog/blog-create';
import BlogEdit from '../components/web/blog/blog-edit';
import Home from '../components/web/home/home';
import Users from '../components/web/users';
import HelloTable from '../components/dashboard/hello/hello-table';
import AuthenticatedGuard from "../shared/guards/authenticated-guard";
import GuestGuard from "../shared/guards/guest-guard";
import PageNotFound from "../shared/components/page-not-found";
const routes = [
  {
    path: "",
    redirect: "/home"
  },
  {
    path: "",
    component: DashboardLayout,
    beforeEnter: [
      AuthenticatedGuard
    ],
    children: [
      { path: "hellos", component: HelloTable },
    ]
  },
  {
    path: "",
    component: WebLayout,
    beforeEnter: [
      GuestGuard
    ],
    children: [
      { path: "register", component: Register },
      { path: "login", component: Login },
      { path: "forget-password", component: ForgetPassword },
      { path: "reset-password/:token", component: ResetPassword },
    ]
  },
  {
    path: "",
    component: WebLayout,
    children: [
      { path: "home", component: Home },
      { path: "users", component: Users },
      { path: "user-blogs/:id", component: UserBlogs },
      { path: "blogs", component: Blogs },
      { path: "blogs/:id", component: BlogDetails },
    ]
  },
  {
    path: "",
    component: WebLayout,
    beforeEnter: [
      AuthenticatedGuard
    ],
    children: [
      { path: "verify-email", component: EmailVerification },
      { path: "profile", component: Profile },
      {
        path: "blogs",
        children: [
          { path: "create", component: BlogCreate },
          { path: "edit/:id", component: BlogEdit },
        ]
      },
    ]
  },
  {
    path: '/:pathMatch(.*)*',
    component: PageNotFound
  }
];
const router = createRouter({
  history: createWebHistory(),
  routes,
  linkActiveClass: 'active',
  scrollBehavior(to, from, savedPosition) {
    if (savedPosition) {
      return savedPosition;
    } else {
      return { top: 0, behavior: 'smooth' }
    }
  },
});
export default router;