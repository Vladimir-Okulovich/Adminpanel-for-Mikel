import store from '../store'

export default [
    // {
    //     path: '/',
    //     meta: {
    //         // authRequired: true,
    //     },
    //     name: 'home',
    //     component: () => import('../contains/dashboard/home'),
    // },
    {
        path: '/login',
        name: 'login',
        component: () => import('../contains/auth/login'),
        meta: {
            beforeResolve(routeTo, routeFrom, next) {
                // If the user is already logged in
                if (store.getters['isAuthenticated']) {
                    // Redirect to the home page instead
                    next({ name: 'Admin' })
                } else {
                    // Continue to the login page
                    next()
                }
            },
        },
    },
    {
        path: '/register',
        name: 'register',
        component: () => import('../contains/auth/register'),
        meta: {
            beforeResolve(routeTo, routeFrom, next) {
                // If the user is already logged in
                if (store.getters['isAuthenticated']) {
                    // Redirect to the home page instead
                    next({ name: 'Admin' })
                } else {
                    // Continue to the login page
                    next()
                }
            },
        },
    },
    {
        path: '/forgot-password',
        name: 'forgot-password',
        component: () => import('../contains/auth/forgot-password'),
        meta: {
            beforeResolve(routeTo, routeFrom, next) {
                // If the user is already logged in
                if (store.getters['isAuthenticated']) {
                    // Redirect to the home page instead
                    next({ name: 'Admin' })
                } else {
                    // Continue to the login page
                    next()
                }
            },
        },  
    },
    {
        path: '/logout',
        name: 'logout',
        meta: {
            authRequired: true,
            beforeResolve(routeTo, routeFrom, next) {
                store.dispatch('logout')
                const authRequiredOnPreviousRoute = routeFrom.matched.some(
                    (route) => route.push('/login')
                )
                // Navigate back to previous page, or home as a fallback
                next(authRequiredOnPreviousRoute ? { name: 'home' } : { ...routeFrom })
            },
        },
    },

    // {
    //     path: '/admin',
    //     name: 'Admin',
    //     component: () => import('../contains/admin/dashboard'),
    //     meta: {
    //         authRequired: true,
    //     },
    // },
    {
        path: '/admin/users',
        name: 'Users',
        component: () => import('../contains/admin/user/users'),
        meta: {
            authRequired: true,
        },
    },
    {
        path: '/admin/user/create',
        name: 'UserCreate',
        component: () => import('../contains/admin/user/user-create'),
        meta: {
            authRequired: true,
        },
    },
    {
        path: '/admin/user/edit/:userId',
        name: 'UserEdit',
        component: () => import('../contains/admin/user/user-edit'),
        meta: {
            authRequired: true,
        },
    },

    {
        path: '/admin/categories',
        name: 'Categories',
        component: () => import('../contains/admin/category/categories'),
        meta: {
            authRequired: true,
        },
    },
    {
        path: '/admin/category/create',
        name: 'CategoryCreate',
        component: () => import('../contains/admin/category/category-create'),
        meta: {
            authRequired: true,
        },
    },
    {
        path: '/admin/category/edit/:categoryId',
        name: 'CategoryEdit',
        component: () => import('../contains/admin/category/category-edit'),
        meta: {
            authRequired: true,
        },
    },

    {
        path: '/admin/lycras',
        name: 'Lycras',
        component: () => import('../contains/admin/lycra/lycras'),
        meta: {
            authRequired: true,
        },
    },
    {
        path: '/admin/lycra/create',
        name: 'LycraCreate',
        component: () => import('../contains/admin/lycra/lycra-create'),
        meta: {
            authRequired: true,
        },
    },
    {
        path: '/admin/lycra/edit/:lycraId',
        name: 'LycraEdit',
        component: () => import('../contains/admin/lycra/lycra-edit'),
        meta: {
            authRequired: true,
        },
    },

    {
        path: '/admin/clubs',
        name: 'Clubs',
        component: () => import('../contains/admin/club/clubs'),
        meta: {
            authRequired: true,
        },
    },
    {
        path: '/admin/club/create',
        name: 'ClubCreate',
        component: () => import('../contains/admin/club/club-create'),
        meta: {
            authRequired: true,
        },
    },
    {
        path: '/admin/club/edit/:clubId',
        name: 'ClubEdit',
        component: () => import('../contains/admin/club/club-edit'),
        meta: {
            authRequired: true,
        },
    },

    {
        path: '/admin/competition_types',
        name: 'CompetitionTypes',
        component: () => import('../contains/admin/competition_type/competition_types'),
        meta: {
            authRequired: true,
        },
    },
    {
        path: '/admin/competition_type/create',
        name: 'CompetitionTypeCreate',
        component: () => import('../contains/admin/competition_type/competition_type-create'),
        meta: {
            authRequired: true,
        },
    },
    {
        path: '/admin/competition_type/edit/:competition_typeId',
        name: 'CompetitionTypeEdit',
        component: () => import('../contains/admin/competition_type/competition_type-edit'),
        meta: {
            authRequired: true,
        },
    },

    {
        path: '/admin/competitions',
        name: 'Competitions',
        component: () => import('../contains/admin/competition/competitions'),
        meta: {
            authRequired: true,
        },
    },
    {
        path: '/admin/competition/create',
        name: 'CompetitionCreate',
        component: () => import('../contains/admin/competition/competition-create'),
        meta: {
            authRequired: true,
        },
    },
    {
        path: '/admin/competition/edit/:competitionId',
        name: 'CompetitionEdit',
        component: () => import('../contains/admin/competition/competition-edit'),
        meta: {
            authRequired: true,
        },
    },
    {
        path: '/admin/competition/participant/create/:competitionId',
        name: 'CompetitionParticipantCreate',
        component: () => import('../contains/admin/participant/competition-participant-create'),
        meta: {
            authRequired: true,
        },
    },

    {
        path: '/admin/participants',
        name: 'Participants',
        component: () => import('../contains/admin/participant/participants'),
        meta: {
            authRequired: true,
        },
    },
    {
        path: '/admin/participant/create',
        name: 'ParticipantCreate',
        component: () => import('../contains/admin/participant/participant-create'),
        meta: {
            authRequired: true,
        },
    },
    {
        path: '/admin/participant/edit/:participantId',
        name: 'ParticipantEdit',
        component: () => import('../contains/admin/participant/participant-edit'),
        meta: {
            authRequired: true,
        },
    },

    {
        path: '/admin/ranking_points',
        name: 'RankingPoints',
        component: () => import('../contains/admin/ranking_points/ranking_points'),
        meta: {
            authRequired: true,
        },
    },
    // {
    //     path: '/admin/ranking_points/create',
    //     name: 'RankingPointsCreate',
    //     component: () => import('../contains/admin/ranking_points/ranking_points-create'),
    //     meta: {
    //         authRequired: true,
    //     },
    // },
    {
        path: '/admin/ranking_points/edit/:rankingId',
        name: 'RankingPointsEdit',
        component: () => import('../contains/admin/ranking_points/ranking_points-edit'),
        meta: {
            authRequired: true,
        },
    },
    {
        path: '/admin/category-modality',
        name: 'CategoryModality',
        component: () => import('../contains/admin/manage_ranking/category-modality'),
        meta: {
            authRequired: true,
        },
    },
]