<template>
    <form class="w-full" @submit.prevent="storeModel">
        
        <div class=" sm:col-span-4">
            <jet-label for="scale_questions_answers" value="Scale Questions Answers" />
            <jig-textarea class="w-full" id="scale_questions_answers" name="scale_questions_answers" v-model="form.scale_questions_answers"
                          :class="{'border-red-500 sm:focus:border-red-300 sm:focus:ring-red-100': form.errors.scale_questions_answers}"
            ></jig-textarea>
            <jet-input-error :message="form.errors.scale_questions_answers" class="mt-2" />
        </div>
                            <div class=" sm:col-span-4">
            <jet-label for="patient" value="Patient" />
            <infinite-select :per-page="15" :api-url="route('api.patients.index')"
                             id="patient" name="patient"
                             v-model="form.patient" label="full_name"
                             :class="{'border-red-500 sm:focus:border-red-300 sm:focus:ring-red-100': form.errors.patient}"
            ></infinite-select>
            <jet-input-error :message="form.errors.patient" class="mt-2" />
        </div>
            <div class=" sm:col-span-4">
            <jet-label for="scale" value="Scale" />
            <infinite-select :per-page="15" :api-url="route('api.scales.index')"
                             id="scale" name="scale"
                             v-model="form.scale" label="title"
                             :class="{'border-red-500 sm:focus:border-red-300 sm:focus:ring-red-100': form.errors.scale}"
            ></infinite-select>
            <jet-input-error :message="form.errors.scale" class="mt-2" />
        </div>

        <div class="mt-2 text-right">
            <inertia-button type="submit" class="font-semibold bg-success disabled:opacity-25" :disabled="form.processing">Submit</inertia-button>
        </div>
    </form>
</template>

<script>
    import JigTextarea from "@/JigComponents/JigTextarea.vue";
    import InfiniteSelect from '@/JigComponents/InfiniteSelect.vue';
    import JetLabel from "@/Jetstream/Label.vue";
    import InertiaButton from "@/JigComponents/InertiaButton.vue";
    import JetInputError from "@/Jetstream/InputError.vue"
    import {useForm} from "@inertiajs/inertia-vue3";
    import { defineComponent } from "vue";

    export default defineComponent({
        name: "CreatePatientScalesForm",
        components: {
            InertiaButton,
            JetInputError,
            JetLabel,
                                                 JigTextarea,             InfiniteSelect,
        },
        data() {
            return {
                form: useForm({
                    scale_questions_answers: null,
                                        "patient": null,
"scale": null,
                    
                }, {remember: false}),
            }
        },
        mounted() {
        },
        computed: {
            flash() {
                return this.$page.props.flash || {}
            }
        },
        methods: {
            async storeModel() {
                this.form.post(this.route('admin.patient-scales.store'),{
                    onSuccess: res => {
                        if (this.flash.success) {
                            this.$emit('success',this.flash.success);
                        } else if (this.flash.error) {
                            this.$emit('error',this.flash.error);
                        } else {
                            this.$emit('error',"Unknown server error.")
                        }
                    },
                    onError: res => {
                        this.$emit('error',"A server error occurred");
                    }
                },{remember: false, preserveState: true})
            }
        }
    });
</script>

<style scoped>

</style>
