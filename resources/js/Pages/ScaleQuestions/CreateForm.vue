<template>
    <form class="w-full" @submit.prevent="storeModel">
        
        <div class=" sm:col-span-4">
            <jet-label for="question" value="Question" />
            <jet-input class="w-full" type="text" id="question" name="question" v-model="form.question"
                       :class="{'border-red-500 sm:focus:border-red-300 sm:focus:ring-red-100': form.errors.question}"
            ></jet-input>
            <jet-input-error :message="form.errors.question" class="mt-2" />
        </div>
            
        <div class=" sm:col-span-4">
            <jet-label for="question_ar" value="Question Ar" />
            <jet-input class="w-full" type="text" id="question_ar" name="question_ar" v-model="form.question_ar"
                       :class="{'border-red-500 sm:focus:border-red-300 sm:focus:ring-red-100': form.errors.question_ar}"
            ></jet-input>
            <jet-input-error :message="form.errors.question_ar" class="mt-2" />
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
    import JetInput from "@/Jetstream/Input.vue";
    import InfiniteSelect from '@/JigComponents/InfiniteSelect.vue';
    import JetLabel from "@/Jetstream/Label.vue";
    import InertiaButton from "@/JigComponents/InertiaButton.vue";
    import JetInputError from "@/Jetstream/InputError.vue"
    import {useForm} from "@inertiajs/inertia-vue3";
    import { defineComponent } from "vue";

    export default defineComponent({
        name: "CreateScaleQuestionsForm",
        components: {
            InertiaButton,
            JetInputError,
            JetLabel,
                         JetInput,                                     InfiniteSelect,
        },
        data() {
            return {
                form: useForm({
                    question: null,
                    question_ar: null,
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
                this.form.post(this.route('admin.scale-questions.store'),{
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
