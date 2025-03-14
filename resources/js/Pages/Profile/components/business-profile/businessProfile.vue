<template>
    <div class="tab-pane fade show active" id="business" role="tabpanel">
        <h4>Business Profile</h4>
        <p>Manage your personal details here.</p>

        <div class="card-bodymt-4">
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
                        <input type="text" class="form-control" v-model="businessForm.dispatch_countries" />
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
                        <input type="text" class="form-control" v-model="businessForm.phone" />
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
                        <label class="form-label">Currency</label>
                        <input type="text" class="form-control" v-model="businessForm.currency" />
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Bank Account Details</label>
                        <input type="text" class="form-control" v-model="businessForm.bank_account_details" />
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Status</label>
                        <select class="form-control" v-model="businessForm.status">
                            <option value="active">Active</option>
                            <option value="inactive">Inactive</option>
                        </select>
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

                <!-- Identity Card Section  -->

                <!-- <hr class="horizontal dark" />
                <div class="row align-items-center g-3">
                    <div class="col-md-3 col-12">
                        <p class="text-uppercase text-sm">
                            Host Identity Card
                        </p>
                    </div>

                    <div class="col-md-6 col-12 ms-auto" v-if="
                        hostData.verification_details
                            ?.front_image_url &&
                        hostData.verification_details
                            ?.back_image_url
                    ">
                        <div class="d-flex justify-content-end gap-2">
                            <button class="btn btn-success" @click.prevent="verifyHostIDCard()" :disabled="hostData.email_verified == 0 ||
                                hostData.mobile_number_verfied ==
                                0 ||
                                hostData.id_verification_verfied ==
                                1 ||
                                hostData.is_verfied == 1
                                ">
                                Verify
                            </button>
                            <button class="btn btn-danger" @click.prevent="rejectHostIDCard()" :disabled="hostData.email_verified == 0 ||
                                hostData.mobile_number_verfied ==
                                0 ||
                                hostData.id_verification_verfied ==
                                1 ||
                                hostData.is_verfied == 1
                                ">
                                Reject
                            </button>
                        </div>
                    </div>
                </div> -->
                <CreateButton class="d-flex float-end" :title="`Create`" v-if="businessForm" />
                <SaveButton class="d-flex float-end" :title="`Save`" v-else />
            </form>
        </div>

    </div>

</template>

<script setup>
import { useForm } from "@inertiajs/vue3";
import { onMounted } from "vue";
import axios from "axios";
import SaveButton from "@/Components/common/buttons/SaveButton.vue";
import CreateButton from "@/Components/common/buttons/CreateButton.vue";

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
    website: "",
    tax_id: "",
    registration_number: "",
    industry: "",
    business_type: "",
    currency: "",
    bank_account_details: "",
    status: true,
    category: "",
    logo: null,
    notes: "",
    created_by: "",
    updated_by: "",
});

const submitBusinessProfileForm = async () => {
    try {
        businessForm.dispatch_countries = businessForm.dispatch_countries
            ? businessForm.dispatch_countries.split(',').map(country => country.trim())
            : [];

        if (businessForm.phone.length > 20) {
            alert("Phone number must not exceed 20 characters.");
            return;
        }

        const response = await axios.post("http://127.0.0.1:8000/business/store", businessForm);
    } catch (error) {
        console.log("Error updating profile:", error.response?.data || error);
    }
};

const handleFileUpload = (event) => {
    businessForm.logo = event.target.files[0];
};

const getBusinessProfileData = async () => {
    try {
        const response = await axios.get(route('business.all'));
        console.log('response', response.data);
    } catch (error) {
        console.log('data', error)
    }
}

onMounted(() => {
    getBusinessProfileData();
});
</script>


<style></style>
