<template>
    <div class="tab-pane fade show active" id="business" role="tabpanel">
        <h4>Business Profile</h4>
        <p>Manage your business details here.</p>

        <div class="mt-4">
            <form @submit.prevent="submitBusinessProfileForm">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Name</label>
                        <input type="text" class="form-control" v-model="businessForm.name" />
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Company Code</label>
                        <input type="text" class="form-control" v-model="businessForm.company_code" />
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">SLBFE Reg Code</label>
                        <input type="text" class="form-control" v-model="businessForm.slbfe_reg_code" />
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Tax ID</label>
                        <input type="text" class="form-control" v-model="businessForm.tax_id" />
                    </div>

                    <div class="col-md-12 mb-3">
                        <label class="form-label">Address</label>
                        <input type="text" class="form-control" v-model="businessForm.address" />
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Postal Code</label>
                        <input type="text" class="form-control" v-model="businessForm.postal_code" />
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">City</label>
                        <input type="text" class="form-control" v-model="businessForm.city" />
                    </div>

                    <div class="col-md-12 mb-3">
                        <label class="form-label">Dispatch Countries</label>
                        <multiselect v-model="businessForm.dispatch_countries" :options="countryOptions"
                            :multiple="true" :taggable="true" @tag="addCountry" placeholder="Select or add countries"
                            label="name" track-by="name"></multiselect>
                    </div>

                    <div class="col-md-12 mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" class="form-control" v-model="businessForm.email" />
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Phone 1</label>
                        <input type="text" class="form-control" v-model="businessForm.phone" />
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Phone 2</label>
                        <input type="text" class="form-control" v-model="businessForm.phone_2" />
                    </div>

                    <div class="col-md-12 mb-3">
                        <label class="form-label">Website</label>
                        <input type="text" class="form-control" v-model="businessForm.website" />
                    </div>


                    <div class="col-md-6 mb-3">
                        <label class="form-label">Registration Number</label>
                        <input type="text" class="form-control" v-model="businessForm.registration_number" />
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Industry</label>
                        <input type="text" class="form-control" v-model="businessForm.industry" />
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Business Type</label>
                        <input type="text" class="form-control" v-model="businessForm.business_type" />
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Base Currency</label>
                        <multiselect id="single-select-search" v-model="businessForm.currency" label="name"
                            :options="currencyOptions" :custom-label="nameWithSymbol" placeholder="Select one"
                            track-by="name" aria-label="pick a value"></multiselect>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Bank Account Details</label>
                        <input type="text" class="form-control" v-model="businessForm.bank_account_details" />
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Status</label>

                        <multiselect id="single-select-search" v-model="businessForm.status"
                            :options="businessStatusOptions" :custom-label="nameWithLang" placeholder="Select one"
                            label="name" track-by="name" aria-label="pick a value"></multiselect>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Category</label>
                        <input type="text" class="form-control" v-model="businessForm.category" />
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Logo</label>
                        <input type="file" class="form-control" @change="handleFileUpload" />
                    </div>

                    <div class="col-md-12 mb-3">
                        <label class="form-label">Notes</label>
                        <textarea class="form-control" v-model="businessForm.notes" rows="3"></textarea>
                    </div>
                </div>
                <CreateButton class="d-flex float-end" :title="`Create`" v-if="!businessForm" />
                <SaveButton class="d-flex float-end" :title="`Save`" v-else />
            </form>
        </div>
    </div>

    <Loader :isLoading="isLoading" />

    <dataSavedAlert v-if="alertMessage" :alertTitle="alertMessage" />

</template>

<script setup>
import { useForm } from "@inertiajs/vue3";
import { onMounted, ref } from "vue";
import axios from "axios";
import SaveButton from "@/Components/common/buttons/SaveButton.vue";
import CreateButton from "@/Components/common/buttons/CreateButton.vue";
import Multiselect from "vue-multiselect";
import Loader from '@/Components/main/Loader.vue';
import dataSavedAlert from '@/Components/alerts/dataSaveAlert.vue'

const countryOptions = ref([]);
const currencyOptions = ref([]);
const isLoading = ref(false)
const alertMessage = ref(null);

const addCountry = (newCountry) => {
    countryOptions.value.push({ name: newCountry });
    businessForm.dispatch_countries.push({ name: newCountry });
};

const businessStatusOptions = [
    { name: 'Active', value: 1 },
    { name: 'Inactive', value: 2 },
    { name: 'Pending', value: 3 },
]

const businessForm = useForm({
    name: "",
    company_code: "",
    slbfe_reg_code: "",
    address: "",
    postal_code: "",
    city: "",
    dispatch_countries: [],
    email: "",
    phone: "",
    phone_2: "",
    website: "",
    tax_id: "",
    registration_number: "",
    industry: "",
    business_type: "",
    currency: "",
    bank_account_details: "",
    status: null,
    category: "",
    logo: null,
    notes: "",
    created_by: "",
    updated_by: "",
});

const submitBusinessProfileForm = async () => {
    isLoading.value = true
    try {

        if (businessForm.phone.length > 20) {
            alert("Phone number must not exceed 20 characters.");
            return;
        }
        businessForm.status = businessForm.status?.name || 'Pending';
        businessForm.currency = businessForm.currency?.name;
        const response = await axios.post("http://127.0.0.1:8000/business/store", businessForm);
        getBusinessProfileData();
        isLoading.value = false
        alertMessage.value = 'Business profile updated successfully';
    } catch (error) {
        console.log("Error updating profile:", error.response?.data || error);

        isLoading.value = false
    }
};

const handleFileUpload = (event) => {
    businessForm.logo = event.target.files[0];
};

const getBusinessProfileData = async () => {
    isLoading.value = true;
    try {
        const response = await axios.get(route('business.all'));
        Object.assign(businessForm, response.data);
        const savedCurrency = businessForm.currency;
        const savedStatus = businessForm.status;
        await getAllCurrencies();
        businessForm.currency = currencyOptions.value.find(currency => currency.name === savedCurrency) || null;
        businessForm.status = businessStatusOptions.find(status => status.name === savedStatus) || null;
        isLoading.value = false;
    } catch (error) {
        console.log('Error fetching business data:', error);
        isLoading.value = false;
    }
};


const getAllCountries = async () => {
    isLoading.value = true;
    try {
        const response = await axios.get(route('countries.all'));
        countryOptions.value = response.data.map(country => ({
            name: country.name,
            id: country.id
        }))

        isLoading.value = false;
    } catch (error) {
        console.log('Error fetching countries data:', error);
        isLoading.value = false;
    }
};

const getAllCurrencies = async () => {

    isLoading.value = true;
    try {
        const response = await axios.get(route('currencies.all'));
        currencyOptions.value = response.data.map(currency => ({
            name: currency.name,
            symbol: currency.symbol,
            id: currency.id,
        }))
        isLoading.value = false;
    } catch (error) {
        console.log('Error fetching countries data:', error);
        isLoading.value = false;
    }
};

const nameWithSymbol = currency => `${currency.name} (${currency.symbol})`;

onMounted(() => {
    getAllCurrencies();
    getAllCountries();
    getBusinessProfileData();
});




</script>


<style></style>
