<template>
    <div class="flex justify-center items-center min-h-screen overflow-x-auto">
        <div class="max-w-screen-md p-8 shadow-lg rounded-md">
            <h2 class="text-center mt-6 font-extrabold">Users List</h2>
            <table class="table mt-2">
                <thead>
                <tr class="cursor-pointer text-blue-500">
                    <th
                        class="px-6 py-3 border-b-2 border-gray-300 text-left leading-4 tracking-wider"
                        @click="sortBy('id')"
                        :class="getSortClass('id')"
                    >Id</th>
                    <th
                        class="px-6 py-3 border-b-2 border-gray-300 text-left leading-4 tracking-wider"
                        @click="sortBy('first_name')"
                        :class="getSortClass('first_name')"
                    >First Name</th>
                    <th
                        class="px-6 py-3 border-b-2 border-gray-300 text-left leading-4 tracking-wider"
                        @click="sortBy('last_name')"
                        :class="getSortClass('last_name')"
                    >Last Name</th>
                    <th
                        class="px-6 py-3 border-b-2 border-gray-300 text-left leading-4 tracking-wider"
                        @click="sortBy('email')"
                        :class="getSortClass('email')"
                    >Email</th>
                </tr>
                </thead>
                <tbody>
                <tr
                    v-for="user in sortedItems" :key="user.id"
                >
                    <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-500">{{ user.id }}</td>
                    <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-500">{{ user.first_name }}</td>
                    <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-500">{{ user.last_name }}</td>
                    <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-500">{{ user.email }}</td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>

<script type="text/javascript">
export default {
    data() {
        return {
            sortData: {
                fieldName: 'id',
                direction: 'asc'
            },
            users: []
        };
    },
    sortField: 'id',
    sortDirection: 'asc',
    created() {
        this.axios
            .get('/users/')
            .then(response => {
                this.users = response.data;
            });
    },
    computed: {
        sortedItems() {
            let list = this.users.slice();
            list.sort((user1, user2) => {
                let valueUser1 = user1[this.sortData.fieldName];
                let valueUser2 = user2[this.sortData.fieldName];

                return (
                    valueUser1 === valueUser2 ?
                        0
                        : (
                            this.isSortedAsc() ?
                                (valueUser1 > valueUser2 ? 1 : -1)
                                : (valueUser1 < valueUser2 ? 1 : -1)
                        )
                );
            });

            return list;
        }
    },
    methods: {
        isSortedAsc() {
            return this.sortData.direction === 'asc';
        },
        sortBy(fieldName) {
            if (this.sortData.fieldName === fieldName) {
                this.sortData.direction = this.isSortedAsc() ? 'desc' : 'asc';
            }
            this.sortData.fieldName = fieldName;
        },
        getSortClass(fieldName) {
            return this.sortData.fieldName === fieldName ? 'sorted-field' + ' ' + this.sortData.direction : '';
        }
    }
};
</script>