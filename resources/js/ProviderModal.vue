<template>
    <Transition name="modal">
        <div v-if="show" class="modal-mask">
            <div class="modal-wrapper">
                <div class="modal-container">
                    <h4 class="mb-3">{{ basic.first_name }} {{ basic.last_name }}</h4>
                    <hr class="mb-4" />
                    <div class="modal-body row">
                        <table class="table">
                            <tbody>
                                <tr>
                                    <td>NPI</td>
                                    <td>{{ providerData.number }}</td>
                                </tr>
                                <tr>
                                    <td>Status</td>
                                    <td>{{ basic.status }}</td>
                                </tr>
                                <tr>
                                    <td>Primary Address</td>
                                    <td>
                                        <Address :addresses="providerData.addresses" :purpose="'LOCATION'" />
                                    </td>
                                </tr>
                                <tr>
                                    <td>Mailing Address</td>
                                    <td>
                                        <Address :addresses="providerData.addresses" :purpose="'MAILING'" />
                                    </td>
                                </tr>
                                <tr>
                                    <td>Taxonomy</td>
                                    <td>
                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    <th scope="col">Primary Taxonomy</th>
                                                    <th scope="col">Selected Taxonomy</th>
                                                    <th scope="col">State</th>
                                                    <th scope="col">License Number</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr v-for="item in taxonomies" :key="item.code">
                                                    <td scope="row">{{ item.primary ? 'Yes' : 'No' }}</td>
                                                    <td scope="row">{{ item.desc }}</td>
                                                    <td scope="row">{{ item.state }}</td>
                                                    <td scope="row">{{ item.license }}</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </td>
                                </tr>
                                <tr>
                                    <td>More Details</td>
                                    <td><a :href="npi_provider_view_url + providerData.number" target="_blank"
                                            rel="noreferrer">Details</a></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <div class="modal-footer">
                        <slot name="footer">
                            <button class="modal-default-button" @click="$emit('close')">Close</button>
                        </slot>
                    </div>
                </div>
            </div>
        </div>
    </Transition>
</template>
<script>
const npi_provider_view_url = 'https://npiregistry.cms.hhs.gov/provider-view/';
export default {
    props: {
        show: Boolean,
        providerData: Object,
    },
    data() {
        return {
            npi_provider_view_url: npi_provider_view_url,
            basic: {},
            taxonomies: [],
            showModal: false,
            currentProvider: {}
        }
    },
    updated() {
        this.basic = this.providerData.basic;
        this.taxonomies = this.providerData.taxonomies;
    },
}
</script>
