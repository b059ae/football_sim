const Welcome = () => import('../views/Welcome.vue')
const Standings = () => import('../views/Standings.vue')
const Schedule = () => import('../views/Schedule.vue')

export default [{
        path: '/',
        component: Welcome,
        name: 'welcome',
    },
    {
        path: '/schedule',
        component: Schedule,
        name: 'schedule',
    },
    {
        path: '/standings',
        component: Standings,
        name: 'standings',
    },
    {
        path: '/:pathMatch(.*)*',
        redirect: '/',
    }
];
