<template>
    <dl class="gap-4">
        <jig-dd>
            <template #dt>Question:</template>
            {{ model.question }}
        </jig-dd>
        <jig-dd>
            <template #dt>Question Ar:</template>
            {{ model.question_ar }}
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
        name: "ShowScaleQuestionsForm",
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
