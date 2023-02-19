<template>
    <dl class="gap-4">
        <jig-dd>
            <template #dt>Scale Questions Answers:</template>
            {{ model.scale_questions_answers }}
        </jig-dd>
            <jig-dd>
            <template #dt>Patient:</template>
            {{ model.patient ? model.patient.full_name : '-' }}
        </jig-dd>
        <jig-dd>
            <template #dt>Scale:</template>
            {{ model.scale ? model.scale.title : '-' }}
        </jig-dd>
    </dl>
</template>

<script>
    import JigDd from "@/JigComponents/JigDd.vue";
    import InertiaButton from "@/JigComponents/InertiaButton.vue";

    import { defineComponent } from "vue";

    export default defineComponent({
        name: "ShowPatientScalesForm",
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
