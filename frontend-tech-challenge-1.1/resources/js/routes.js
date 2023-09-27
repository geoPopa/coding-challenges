const UserList = () => import('./components/users/List.vue');

// eslint-disable-next-line import/prefer-default-export
export const routes = [
  {
    name: 'home',
    path: '/users',
    component: UserList,
  },
];
