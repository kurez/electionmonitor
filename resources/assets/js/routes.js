import VueRouter from 'vue-router'
import helper from './services/helper'

let routes = [
    {
        path: '/',
        component: require('./layouts/default-page.vue').default,
        meta: { requiresAuth: true },
        children: [
            {
                path: '/dashboard',
                component: require('./views/pages/Dashboard.vue').default
            },
            {
                path: '/polling',
                component: require('./views/pages/pollings.vue').default
            },
            {
                path: '/county',
                component: require('./views/pages/counties.vue').default
            },
            {
                path: '/constituency',
                component: require('./views/pages/constituencies.vue').default
            },
            {
                path: '/ward',
                component: require('./views/pages/wards.vue').default
            },
            {
                path: '/configuration',
                component: require('./views/configuration/configuration.vue').default
            },
            {
                path: '/aspirant',
                component: require('./views/aspirant/index.vue').default
            },
            {
                path: '/aspirant/add',
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
                path: '/user/add',
                component: require('./views/user/add.vue').default
            },
            {
                path: '/user/:id/edit',
                component: require('./views/user/edit.vue').default
            },

            {
                path: '/home/:id/agent',
                name: 'agentHome',
                component: require('./views/pages/Home.vue').default
            },
            {
                path: '/enter-results/:electoral_area',
                name: 'agentHome',
                component: require('./views/pages/EnterResults.vue').default
            },
        ]
    },
    // {
    //     path: '/home/:id/agent',
    //     component: require('./layouts/agent-page.vue').default,
    //     meta: { requiresAuth: true },
    //     children: [
    //         component: require('./views/pages/Home.vue').default,
    //     ]
    // },
    {
        path: '/',
        component: require('./layouts/guest-page.vue').default,
        meta: { requiresGuest: true },
        children: [
            {
                path: '/login',
                name: 'login',
                component: require('./views/auth/login.vue').default
            },
            // {
            //     path: '/password',
            //     component: require('./views/auth/password.vue').default
            // },
            // {
            //     path: '/register',
            //     component: require('./views/auth/register.vue').default
            // },
            // {
            //     path: '/auth/:token/activate',
            //     component: require('./views/auth/activate.vue').default
            // },
            // {
            //     path: '/password/reset/:token',
            //     component: require('./views/auth/reset.vue').default
            // },
            // {
            //     path: '/auth/social',
            //     component: require('./views/auth/social-auth.vue').default
            // },
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
