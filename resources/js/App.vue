<template>
    <h4 class="mb-3">Search NPI Records</h4>
    <hr class="mb-4" />
    <div v-for="item in errors" class="alert alert-danger" role="alert">
        {{ item.description }}
    </div>

    <form v-on:submit.prevent="submitForm">
        <div class="row">
            <div class="col-md-6 mb-3">
                <div class="form-group">
                    <label for="first_name">First Name</label>
                    <input type="text" id="first_name" class="form-control" v-model.text="providerLookup.first_name">
                </div>
            </div>
            <div class="col-md-6 mb-3">
                <div class="form-group">
                    <label for="last_name">Last Name</label>
                    <input type="text" id="last_name" class="form-control" v-model.text="providerLookup.last_name">
                </div>
            </div>
        </div>
        <div class="form-group">
            <label for="npi_number">Npi Number</label>
            <input type="number" id="npi_number" class="form-control" v-model.number="providerLookup.number">
        </div>
        <div class="form-group">
            <label for="taxonomy">Taxonomy</label>
            <input type="text" id="taxonomy" class="form-control" v-model.text="providerLookup.taxonomy_description">
        </div>
        <div class="row">
            <div class="col-md-5 mb-3">
                <div class="form-group">
                    <label for="city">City</label>
                    <input type="text" id="city" class="form-control" v-model.text="providerLookup.city">
                </div>
            </div>
            <div class="col-md-4 mb-3">
                <div class="form-group">
                    <label for="state">State</label>
                    <LocalePicker :locations="supportedLocales.STATES" @localeChanged="stateChanged" />
                </div>
            </div>
            <div class="col-md-3 mb-3">
                <div class="form-group">
                    <label for="postal_code">Postal Code</label>
                    <input type="text" id="postal_code" class="form-control" v-model.text="providerLookup.postal_code">
                </div>
            </div>
        </div>
        <div class="form-group">
            <label for="country">Country</label>
            <LocalePicker :locations="supportedLocales.COUNTRIES" @localeChanged="countryChanged" />
        </div>
        <hr class="mb-4" />
        <div class="form-group">
            <button class="btn btn-primary btn-lg btn-block" type="submit">Search Records</button>
        </div>
    </form>
    <LookupResults :items="lookupResults" />

    <button :disabled="providerLookup.skip == 0" v-if="lookupResults.length" class="btn"
        @click="setPage(currentPage - 1)">Previous</button>
    <button :disabled="lookupResults.length < providerLookup.limit" v-if="lookupResults.length" class="btn"
        @click="setPage(currentPage + 1)">Next</button>

    <ProviderModal />
</template>
<script>
import SupportedLocales from './config.js';

const default_form = {
    number: '',
    first_name: '',
    last_name: '',
    taxonomy_description: '',
    city: '',
    state: '',
    country_code: '',
    postal_code: '',
    limit: 50,
    skip: 0
}

export default {
    setup() {
        console.log("loaded");
    },
    data() {
        return {
            supportedLocales: SupportedLocales,
            currentPage: 0,
            errors: [],
            providerLookup: default_form,
            lookupResults: []
        }
    },
    methods: {
        countryChanged(country_code) {
            this.providerLookup.country_code = country_code;
            console.log(`country changed to ${country_code}`);
        },
        stateChanged(state_code) {
            this.providerLookup.state = state_code;
            console.log(`state changed to ${state_code}`);
        },
        setPage(page) {
            this.currentPage = page;
            this.providerLookup.skip = page * this.providerLookup.limit;
            this.submitForm(false);
        },
        clearErrors() {
            this.errors = [];
        },
        clearForm() {
            this.providerLookup = default_form;
        },
        submitForm(newSearch = true) {
            this.clearErrors();
            if (newSearch) {
                this.providerLookup.skip = 0;
            }
            axios.get('/api/lookup', { params: this.providerLookup })
                .then((res) => {
                    this.errors = res.data.Errors ?? [];
                    this.lookupResults = res.data.results ?? [];
                })
                .catch((error) => {
                    console.log(error);
                    // TODO ZS what conditions cause an error?
                });
        }
    }
}
</script>
