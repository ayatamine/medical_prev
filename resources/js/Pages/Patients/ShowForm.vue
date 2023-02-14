<template>
    <dl class="gap-4">
        <jig-dd>
            <template #dt>Full Name:</template>
            {{ model.full_name }}
        </jig-dd>
        <jig-dd>
            <template #dt>Birth Date:</template>
            {{ model.birth_date }}
        </jig-dd>
        <jig-dd>
            <template #dt>Thumbnail:</template>
            {{ model.thumbnail }}
        </jig-dd>
        <jig-dd>
            <template #dt>Phone Number:</template>
            {{ model.phone_number }}
        </jig-dd>
        <jig-dd>
            <template #dt>Otp Verification Code:</template>
            {{ model.otp_verification_code }}
        </jig-dd>
        <jig-dd>
            <template #dt>Gender:</template>
            {{ model.gender }}
        </jig-dd>
        <jig-dd>
            <template #dt>Address:</template>
            {{ model.address }}
        </jig-dd>
        <jig-dd>
            <template #dt>Other Problems:</template>
            {{ model.other_problems }}
        </jig-dd>
        <jig-dd>
            <template #dt>Height:</template>
            {{ model.height }}
        </jig-dd>
        <jig-dd>
            <template #dt>Weight:</template>
            {{ model.weight }}
        </jig-dd>
        <jig-dd>
            <template #dt>Otp Expire At:</template>
            {{ model.otp_expire_at }}
        </jig-dd>
        <jig-dd>
            <template #dt>Notification Status:</template>
            {{ model.notification_status }}
        </jig-dd>
        <jig-dd>
            <template #dt>Has Physical Activity:</template>
            {{ model.has_physical_activity }}
        </jig-dd>
        <jig-dd>
            <template #dt>Has Cancer Screening:</template>
            {{ model.has_cancer_screening }}
        </jig-dd>
        <jig-dd>
            <template #dt>Has Depression Screening:</template>
            {{ model.has_depression_screening }}
        </jig-dd>
        <jig-dd>
            <template #dt>Account Status:</template>
            {{ model.account_status }}
        </jig-dd>
        <jig-dd>
            <template #dt>Age:</template>
            {{ model.age }}
        </jig-dd>
            <jig-dd>
            <template #dt>Chronic Disease:</template>
            {{ model.chronic_disease ? model.chronic_disease.name : '-' }}
        </jig-dd>
        <jig-dd>
            <template #dt>Allergy:</template>
            {{ model.allergy ? model.allergy.name : '-' }}
        </jig-dd>
        <jig-dd>
            <template #dt>Family History:</template>
            {{ model.family_history ? model.family_history.name : '-' }}
        </jig-dd>
    </dl>
</template>

<script>
    import JigDd from "@/JigComponents/JigDd.vue";
    import InertiaButton from "@/JigComponents/InertiaButton.vue";

    import { defineComponent } from "vue";

    export default defineComponent({
        name: "ShowPatientsForm",
        props: {
            model: Object,
        },
        components: {
            InertiaButton,
            JigDd,
        },
        data() {
            return {}
        },
        mounted() {},
        computed: {
            flash() {
                return this.$page.props.flash || {}
            }
        },
        methods: {}
    });
</script>

<style scoped>

</style>
