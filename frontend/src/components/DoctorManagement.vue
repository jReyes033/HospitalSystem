<template>
    <DashboardView/>
    <div class="hello">
        <h1>Doctor Management</h1>
        <button class="btn btn-info btn-sm m-1" @click="addDoctor()">Add a Doctor</button>
        <table class="table table-striped table-bordered">
            <thead class="thead-dark">
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="doctor in doctors" :key="doctor.id">
                    <td>{{ doctor.id }}</td>
                    <td>{{ doctor.name }}</td>
                    <td>{{ doctor.email }}</td>
                    <td>
                        <button class="btn btn-warning btn-sm m-1" @click="editDoctor(doctor)">Edit</button>
                        <button class="btn btn-danger btn-sm m-1" @click="deleteDoctor(doctor)">Delete</button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

    <Modal v-if="showAddDoctorModal" @close="showAddDoctorModal = false">
        <template v-slot:header>
            <h5>Add New Doctor</h5>
        </template>
        <template v-slot:body>
            <form @submit.prevent="postDoctor">
                <div class="form-group">
                    <label for="newDoctorName">Name</label>
                    <input type="text" class="form-control" id="newDoctorName" v-model="newDoctorData.name">
                </div>
                <div class="form-group">
                    <label for="newDoctorEmail">Email</label>
                    <input type="text" class="form-control" id="newDoctorEmail" v-model="newDoctorData.email">
                </div>
                <div class="form-group">
                    <label for="newDoctorPassword">Password</label>
                    <input type="password" class="form-control" id="newDoctorPassword" v-model="newDoctorData.password">
                </div>
                <button type="submit" class="btn btn-primary">Add</button>
            </form>
        </template>
    </Modal>

    <Modal v-if="showEditDoctorModal" @close="showEditDoctorModal = false">
        <template v-slot:header>
            <h5>Edit Doctor Details</h5>
        </template>
        <template v-slot:body>
            <form @submit.prevent="updateDoctor()">
                <div class="form-group">
                    <label for="newDoctorName">Name</label>
                    <input type="text" class="form-control" id="newDoctorName" v-model="editDoctorData.name">
                </div>
                <div class="form-group">
                    <label for="newDoctorEmail">Email</label>
                    <input type="text" class="form-control" id="newDoctorEmail" v-model="editDoctorData.email">
                </div>
                <div class="form-group">
                    <label for="newDoctorPassword">Password</label>
                    <input type="password" class="form-control" id="newDoctorPassword" v-model="editDoctorData.password">
                </div>
                <button type="submit" class="btn btn-primary m-1">Update</button>
            </form>
        </template>
    </Modal>
</template>

<script>
import Modal from './PopUpModal.vue';
import axios from 'axios';
import DashboardView from '@/views/DashboardView.vue';

export default {
    name: 'DoctorManagement',
    components: {
        Modal,
        DashboardView
    },
    data() {
        return {
            doctors: [],
            showAddDoctorModal: false,
            showEditDoctorModal: false,
            newDoctorData: {
                name: '',
                email: '',
                password: '',
                userType: 'doctor'
            },
            editDoctorData: {
                id: '',
                name: '',
                email: '',
                password: '',
                userType: 'doctor',
                updated_at: ''
            }
        };
    },
    mounted() {
        this.fetchDoctors();
    },
    methods: {
        fetchDoctors() {
            fetch('http://127.0.0.1:8000/api/doctor', {
                method: 'GET',
                headers: {
                    'Content-Type': 'application/json',
                    'Authorization': 'Bearer ' + localStorage.getItem('token')
                },
            })
                .then(response => response.json())
                .then(data => {
                    this.doctors = data.DoctorAccounts;
                })
                .catch(err => {
                    if (err.response) {
                        this.error = `Error: ${err.response.data.message}`;
                        console.error(err.response.data);
                    } else if (err.request) {
                        this.error = 'No response from server. Please try again later.';
                        console.error(err.request);
                    } else {
                        this.error = 'Request error. Please check your input and try again.';
                        console.error('Error', err.message);
                    }
                });
        },
        addDoctor() {
            this.showAddDoctorModal = true;
        },
        async postDoctor() {
            try {
                await axios.post('http://127.0.0.1:8000/api/doctor', this.newDoctorData, {
                    headers: {
                        'Content-Type': 'application/json',
                        'Authorization': 'Bearer ' + localStorage.getItem('token')
                    }
                });
                this.showAddDoctorModal = false;
            } catch (error) {
                console.error('There was an error adding the product:', error);
            }
            this.fetchDoctors();
        },
        editDoctor(doctor) {
            this.editDoctorData = { ...doctor };
            this.showEditDoctorModal = true;
        },
        async updateDoctor() {
            this.editDoctorData.updated_at = new Date().toISOString();
            await axios.put(`http://127.0.0.1:8000/api/doctor/${this.editDoctorData.id}`, this.editDoctorData, {
                headers: {
                    'Content-Type': 'application/json',
                    'Authorization': 'Bearer ' + localStorage.getItem('token')
                }
            });
            this.showEditDoctorModal = false;
            this.fetchDoctors();
        },
        async deleteDoctor(doctor) {
            const index = this.doctors.findIndex(d => d.id === doctor.id);
            if (index !== -1) {
                this.doctors.splice(index, 1);
            }
            try {
                await axios.delete(`http://127.0.0.1:8000/api/doctor/${doctor.id}`, {
                    headers: {
                        'Content-Type': 'application/json',
                        'Authorization': 'Bearer ' + localStorage.getItem('token')
                    }
                });
            } catch (error) {
                console.error('There was an error deleting the product:', error);
            }
        }
    }
};
</script>
