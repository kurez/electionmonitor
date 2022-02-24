import VueRouter from 'vue-router'
import helper from './services/helper'

let routes = [
    {
        path: '/',
        component: require('./layouts/default-page.vue').default,
        meta: { requiresAuth: true },
        children: [
            {
                path: '/',
                component: require('./views/pages/home.vue').default
            },
            {
                path: '/home',
                component: require('./views/pages/home.vue').default
            },
            {
                path: '/blank',
                component: require('./views/pages/blank.vue').default
            },
            {
                path: '/configuration',
                component: require('./views/configuration/configuration.vue').default
            },
            {
                path: '/profile',
                component: require('./views/user/profile.vue').default
            },
            {
                path: '/aspirant',
                component: require('./views/aspirant/index.vue').default
            },
            {
                path: '/add/aspirant',
                component: require('./views/aspirant/add.vue').default
            },
            {
                path: '/aspirant/:id/edit',
                component: require('./views/aspirant/edit.vue').default
            },
            {
                path: '/user',
                component: require('./views/user/index.vue').default
            },
            {
                path: '/add/user',
                component: require('./views/user/register.vue').default
            },
            {
                path: '/user/:id/edit',
                component: require('./views/user/edit.vue').default
            },
        ]
    },
    {
        path: '/',
        component: require('./layouts/guest-page.vue').default,
        meta: { requiresGuest: true },
        children: [
            {
                path: '/login',
                component: require('./views/auth/login.vue').default
            },
            {
                path: '/password',
                component: require('./views/auth/password.vue').default
            },
            {
                path: '/register',
                component: require('./views/auth/register.vue').default
            },
            {
                path: '/auth/:token/activate',
                component: require('./views/auth/activate.vue').default
            },
            {
                path: '/password/reset/:token',
                component: require('./views/auth/reset.vue').default
            },
            {
                path: '/auth/social',
                component: require('./views/auth/social-auth.vue').default
            },
        ]
    },
    {
        path: '*',
        component : require('./layouts/error-page.vue').default,
        children: [
            {
                path: '*',
                component: require('./views/errors/page-not-found.vue').default
            }
        ]
    }
];

const router = new VueRouter({
	routes,
    linkActiveClass: 'active',
    mode: 'history'
});

router.beforeEach((to, from, next) => {

    if (to.matched.some(m => m.meta.requiresAuth)){
        return helper.check().then(response => {
            if(!response){
                return next({ path : '/login'})
            }

            return next()
        })
    }

    if (to.matched.some(m => m.meta.requiresGuest)){
        return helper.check().then(response => {
            if(response){
                return next({ path : '/'})
            }

            return next()
        })
    }

    return next()
});

export default router;
