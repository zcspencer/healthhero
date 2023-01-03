<template>
    <select class="form-control" v-model="selectedLocale" @change="changeLocale">
        <option v-for="locale in locations" v-bind:value="locale.code">
            {{ locale.name }}
        </option>
    </select>
</template>
<script>
export default {
    setup() {
        console.log("loaded");
    },
    props: {
        selectedLocale: {
            default: '',
        },
        locations: {
            default: [],
        },
    },
    data() {
        return {
        }
    },
    methods: {
        changeLocale() {
            this.$emit('localeChanged', this.selectedLocale);
        }
    }
}
</script>
