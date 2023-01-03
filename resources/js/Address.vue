<template>
    {{ address.address_1 }} {{ address.city }}, {{ address.state }} {{ address.postal_code }}
</template>
<script>
export default {
    mounted() {
        this.address = this.addresses.find(f => f.address_purpose == this.purpose);
    },
    props: {
        addresses: {
            default: [],
            
        },
        purpose: {
            default: '',
            likes: String,

        },
        
    },
    data() {
        return {
            address: {},
        }
    }
}
</script>
