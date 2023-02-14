<template>
    <form class="w-full" @submit.prevent="storeModel">
        
        <div class=" sm:col-span-4">
            <jet-label for="full_name" value="Full Name" />
            <jet-input class="w-full" type="text" id="full_name" name="full_name" v-model="form.full_name"
                       :class="{'border-red-500 sm:focus:border-red-300 sm:focus:ring-red-100': form.errors.full_name}"
            ></jet-input>
            <jet-input-error :message="form.errors.full_name" class="mt-2" />
        </div>
            
        <div class=" sm:col-span-4">
            <jet-label for="birth_date" value="Birth Date" />
            <jet-input class="w-full" type="text" id="birth_date" name="birth_date" v-model="form.birth_date"
                       :class="{'border-red-500 sm:focus:border-red-300 sm:focus:ring-red-100': form.errors.birth_date}"
            ></jet-input>
            <jet-input-error :message="form.errors.birth_date" class="mt-2" />
        </div>
            
        <div class=" sm:col-span-4">
            <jet-label for="thumbnail" value="Thumbnail" />
            <jet-input class="w-full" type="text" id="thumbnail" name="thumbnail" v-model="form.thumbnail"
                       :class="{'border-red-500 sm:focus:border-red-300 sm:focus:ring-red-100': form.errors.thumbnail}"
            ></jet-input>
            <jet-input-error :message="form.errors.thumbnail" class="mt-2" />
        </div>
            
        <div class=" sm:col-span-4">
            <jet-label for="phone_number" value="Phone Number" />
            <jet-input class="w-full" type="text" id="phone_number" name="phone_number" v-model="form.phone_number"
                       :class="{'border-red-500 sm:focus:border-red-300 sm:focus:ring-red-100': form.errors.phone_number}"
            ></jet-input>
            <jet-input-error :message="form.errors.phone_number" class="mt-2" />
        </div>
            
        <div class=" sm:col-span-4">
            <jet-label for="otp_verification_code" value="Otp Verification Code" />
            <jet-input class="w-full" type="text" id="otp_verification_code" name="otp_verification_code" v-model="form.otp_verification_code"
                       :class="{'border-red-500 sm:focus:border-red-300 sm:focus:ring-red-100': form.errors.otp_verification_code}"
            ></jet-input>
            <jet-input-error :message="form.errors.otp_verification_code" class="mt-2" />
        </div>
            
        <div class=" sm:col-span-4">
            <jet-label for="gender" value="Gender" />
            <jet-input class="w-full" type="text" id="gender" name="gender" v-model="form.gender"
                       :class="{'border-red-500 sm:focus:border-red-300 sm:focus:ring-red-100': form.errors.gender}"
            ></jet-input>
            <jet-input-error :message="form.errors.gender" class="mt-2" />
        </div>
            
        <div class=" sm:col-span-4">
            <jet-label for="address" value="Address" />
            <jet-input class="w-full" type="text" id="address" name="address" v-model="form.address"
                       :class="{'border-red-500 sm:focus:border-red-300 sm:focus:ring-red-100': form.errors.address}"
            ></jet-input>
            <jet-input-error :message="form.errors.address" class="mt-2" />
        </div>
            
        <div class=" sm:col-span-4">
            <jet-label for="other_problems" value="Other Problems" />
            <jig-textarea class="w-full" id="other_problems" name="other_problems" v-model="form.other_problems"
                          :class="{'border-red-500 sm:focus:border-red-300 sm:focus:ring-red-100': form.errors.other_problems}"
            ></jig-textarea>
            <jet-input-error :message="form.errors.other_problems" class="mt-2" />
        </div>
            
        <div class=" sm:col-span-4">
            <jet-label for="height" value="Height" />
            <jet-input class="w-full" type="text" id="height" name="height" v-model="form.height"
                       :class="{'border-red-500 sm:focus:border-red-300 sm:focus:ring-red-100': form.errors.height}"
            ></jet-input>
            <jet-input-error :message="form.errors.height" class="mt-2" />
        </div>
            
        <div class=" sm:col-span-4">
            <jet-label for="weight" value="Weight" />
            <jet-input class="w-full" type="text" id="weight" name="weight" v-model="form.weight"
                       :class="{'border-red-500 sm:focus:border-red-300 sm:focus:ring-red-100': form.errors.weight}"
            ></jet-input>
            <jet-input-error :message="form.errors.weight" class="mt-2" />
        </div>
            
        <div class=" sm:col-span-4">
            <jet-label for="otp_expire_at" value="Otp Expire At" />
            <jig-datepicker class="w-full"
                            data-date-format="Y-m-d H:i:s"
                            :data-alt-input="true"
                            data-alt-format="l M J, Y at h:i K"
                            data-default-hour="9"
                            :data-enable-time="true"
                            name="otp_expire_at"
                            v-model="form.otp_expire_at"
                            id="otp_expire_at"
                            :class="{'border-red-500 sm:focus:border-red-300 sm:focus:ring-red-100': form.errors.otp_expire_at}"
            ></jig-datepicker>
            <jet-input-error :message="form.errors.otp_expire_at" class="mt-2" />
        </div>
            
        <div class=" sm:col-span-4">
            <jet-label for="notification_status" value="Notification Status" />
            <jet-checkbox class="p-2" type="checkbox" id="notification_status" name="notification_status" v-model="form.notification_status"
                          :class="{'border-red-500 sm:focus:border-red-300 sm:focus:ring-red-100': form.errors.notification_status}"
            ></jet-checkbox>
            <jet-input-error :message="form.errors.notification_status" class="mt-2" />
        </div>
            
        <div class=" sm:col-span-4">
            <jet-label for="has_physical_activity" value="Has Physical Activity" />
            <jet-checkbox class="p-2" type="checkbox" id="has_physical_activity" name="has_physical_activity" v-model="form.has_physical_activity"
                          :class="{'border-red-500 sm:focus:border-red-300 sm:focus:ring-red-100': form.errors.has_physical_activity}"
            ></jet-checkbox>
            <jet-input-error :message="form.errors.has_physical_activity" class="mt-2" />
        </div>
            
        <div class=" sm:col-span-4">
            <jet-label for="has_cancer_screening" value="Has Cancer Screening" />
            <jet-checkbox class="p-2" type="checkbox" id="has_cancer_screening" name="has_cancer_screening" v-model="form.has_cancer_screening"
                          :class="{'border-red-500 sm:focus:border-red-300 sm:focus:ring-red-100': form.errors.has_cancer_screening}"
            ></jet-checkbox>
            <jet-input-error :message="form.errors.has_cancer_screening" class="mt-2" />
        </div>
            
        <div class=" sm:col-span-4">
            <jet-label for="has_depression_screening" value="Has Depression Screening" />
            <jet-checkbox class="p-2" type="checkbox" id="has_depression_screening" name="has_depression_screening" v-model="form.has_depression_screening"
                          :class="{'border-red-500 sm:focus:border-red-300 sm:focus:ring-red-100': form.errors.has_depression_screening}"
            ></jet-checkbox>
            <jet-input-error :message="form.errors.has_depression_screening" class="mt-2" />
        </div>
            
        <div class=" sm:col-span-4">
            <jet-label for="account_status" value="Account Status" />
            <jet-checkbox class="p-2" type="checkbox" id="account_status" name="account_status" v-model="form.account_status"
                          :class="{'border-red-500 sm:focus:border-red-300 sm:focus:ring-red-100': form.errors.account_status}"
            ></jet-checkbox>
            <jet-input-error :message="form.errors.account_status" class="mt-2" />
        </div>
            
        <div class=" sm:col-span-4">
            <jet-label for="age" value="Age" />
            <jet-input class="w-full" type="number" id="age" name="age" v-model="form.age"
                       :class="{'border-red-500 sm:focus:border-red-300 sm:focus:ring-red-100': form.errors.age}"
            ></jet-input>
            <jet-input-error :message="form.errors.age" class="mt-2" />
        </div>
                            <div class=" sm:col-span-4">
            <jet-label for="chronic_disease" value="Chronic Disease" />
            <infinite-select :per-page="15" :api-url="route('api.chronic-diseases.index')"
                             id="chronic_disease" name="chronic_disease"
                             v-model="form.chronic_disease" label="name"
                             :class="{'border-red-500 sm:focus:border-red-300 sm:focus:ring-red-100': form.errors.chronic_disease}"
            ></infinite-select>
            <jet-input-error :message="form.errors.chronic_disease" class="mt-2" />
        </div>
            <div class=" sm:col-span-4">
            <jet-label for="allergy" value="Allergy" />
            <infinite-select :per-page="15" :api-url="route('api.allergies.index')"
                             id="allergy" name="allergy"
                             v-model="form.allergy" label="name"
                             :class="{'border-red-500 sm:focus:border-red-300 sm:focus:ring-red-100': form.errors.allergy}"
            ></infinite-select>
            <jet-input-error :message="form.errors.allergy" class="mt-2" />
        </div>
            <div class=" sm:col-span-4">
            <jet-label for="family_history" value="Family History" />
            <infinite-select :per-page="15" :api-url="route('api.family-histories.index')"
                             id="family_history" name="family_history"
                             v-model="form.family_history" label="name"
                             :class="{'border-red-500 sm:focus:border-red-300 sm:focus:ring-red-100': form.errors.family_history}"
            ></infinite-select>
            <jet-input-error :message="form.errors.family_history" class="mt-2" />
        </div>

        <div class="mt-2 text-right">
            <inertia-button type="submit" class="font-semibold bg-success disabled:opacity-25" :disabled="form.processing">Submit</inertia-button>
        </div>
    </form>
</template>

<script>
    import JetCheckbox from "@/Jetstream/Checkbox.vue";
    import JigDatepicker from "@/JigComponents/JigDatepicker.vue";
    import JetInput from "@/Jetstream/Input.vue";
    import JigTextarea from "@/JigComponents/JigTextarea.vue";
    import InfiniteSelect from '@/JigComponents/InfiniteSelect.vue';
    import JetLabel from "@/Jetstream/Label.vue";
    import InertiaButton from "@/JigComponents/InertiaButton.vue";
    import JetInputError from "@/Jetstream/InputError.vue"
    import {useForm} from "@inertiajs/inertia-vue3";
    import { defineComponent } from "vue";

    export default defineComponent({
        name: "CreatePatientsForm",
        components: {
            InertiaButton,
            JetInputError,
            JetLabel,
             JigDatepicker,             JetInput,             JetCheckbox,             JigTextarea,             InfiniteSelect,
        },
        data() {
            return {
                form: useForm({
                    full_name: null,
                    birth_date: null,
                    thumbnail: null,
                    phone_number: null,
                    otp_verification_code: null,
                    gender: null,
                    address: null,
                    other_problems: null,
                    height: null,
                    weight: null,
                    otp_expire_at: null,
                    notification_status: false,
                    has_physical_activity: false,
                    has_cancer_screening: false,
                    has_depression_screening: false,
                    account_status: false,
                    age: null,
                                        "chronic_disease": null,
"allergy": null,
"family_history": null,
                    
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
                this.form.post(this.route('admin.patients.store'),{
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
