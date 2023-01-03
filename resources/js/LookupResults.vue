<template>
    <table class="table">
        <thead>
            <tr>
                <th scope="col">NPI</th>
                <th scope="col">Name</th>
                <th scope="col">Primary Address</th>
                <th scope="col">Primary Taxonomy</th>
                <th scope="col"></th>
            </tr>
        </thead>
        <tbody>
            <tr v-for="item in items" :key="item.number">
                <th scope="row">{{ item.number }}</th>
                <td>{{ item.basic.first_name }} {{ item.basic.last_name }}</td>
                <td><Address :addresses="item.addresses" :purpose="'LOCATION'"/></td>
                <td>{{ item.taxonomies.map(t => t.desc).join(', ') }}</td>
                <td>
                    <button @click="showProviderData(item)">Details</button>
                </td>
            </tr>
        </tbody>
    </table>
    <Teleport to="body">
        <!-- use the modal component, pass in the prop -->
        <ProviderModal :providerData="currentProvider" :show="showModal" @close="showModal = false" />
    </Teleport>
</template>
<script>
import ProviderModal from './ProviderModal.vue'

export default {
    components: {
        ProviderModal,
    },
    props: {
        items: {
            type: Array,
        },
    },
    data() {
        return {
            showModal: false,
            currentProvider: {}
        }
    },
    methods: {
        onChangePage(items) {
            this.items = items;
        },
        showProviderData(provider) {
            this.currentProvider = provider;
            this.showModal=true;
        }
    }
}
</script>

