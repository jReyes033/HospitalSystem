<template>
  <nav>
    <router-link v-if="isAdmin" to="/doctors">Doctor Management |</router-link>
    <router-link v-if="isAdmin" to="/patients"> Patient Management |</router-link>
    <router-link v-if="isAdmin" to="/appointments"> Appointment Management |</router-link>
    <router-link v-if="isAdmin" to="/medicalrecords"> Medical Record Management |</router-link>
    <router-link v-if="isAdmin" to="/users"> Admin View |</router-link>


    <router-link v-if="isDoctor" to="/patients"> My Patients |</router-link>
    <router-link v-if="isDoctor || isPatient" to="/appointments"> My Appointments |</router-link>
    <router-link v-if="isDoctor || isPatient" to="/medicalrecords"> My Medical Records |</router-link>

    <!-- <router-link v-if="isDoctor || isPatient">My Profile</router-link> -->
    <router-link to="/logout"> Logout |</router-link>
    <br>
    <button type="submit" class="btn btn-primary m-1" @click="viewprofile()">My Profile</button>
  </nav>

  <Modal v-if="showeditUserModal" @close="showeditUserModal = false">
    <template v-slot:header>
      <h5>Edit Profile Details</h5>
    </template>
    <template v-slot:body>
      <form @submit.prevent="updateUser()" class="registration-form">
        <div class="form-group">
          <label for="name">Name:</label>
          <input class="form-control" type="text" v-model="editUserData.name" id="name" required>
        </div>
        <div class="form-group">
          <label for="email">Email:</label>
          <input class="form-control" type="text" v-model="editUserData.email" id="email" required>
        </div>
        <div class="form-group">
          <label for="password">Password:</label>
          <input class="form-control" type="password" v-model="editUserData.password" id="password" required>
        </div>
        <div class="form-group">
          <label for="userType">User Type:</label>
          <select class="form-control" id="userType" v-model="editUserData.userType" required>
            <option value="admin">Administrator</option>
            <option value="doctor">Doctor</option>
            <option value="patient">Patient</option>
          </select>
        </div>
        <button type="submit" class="btn btn-primary m-1">Update</button>
      </form>
    </template>
  </Modal>

  <router-view />
</template>

<script>
import Modal from '@/components/PopUpModal.vue';
import axios from 'axios';

export default {
  name: 'DashBoard',
  components: {
    Modal
  },
  data() {
    return {
      user: null,
      showeditUserModal: false,
      editUserData: {
        id: '',
        name: '',
        email: '',
        password: '',
        userType: '',
        updated_at: ''
      },
    };
  },
  computed: {
    isAdmin() {
      return this.user && this.user.userType === 'admin';
    },
    isDoctor() {
      return this.user && this.user.userType === 'doctor';
    },
    isPatient() {
      return this.user && this.user.userType === 'patient';
    },
  },
  created() {
    this.loadUserFromLocalStorage();
  },
  methods: {
    loadUserFromLocalStorage() {
      const user = localStorage.getItem('user');
      if (user) {
        this.user = JSON.parse(user);
        this.editUserData = {...this.user};
      }
    },
    viewprofile() {
      this.showeditUserModal = true;
    },
    async updateUser() {
            this.editUserData.updated_at = new Date().toISOString();
            await axios.put(`http://127.0.0.1:8000/api/doctor/${this.editUserData.id}`, this.editUserData, {
                headers: {
                    'Content-Type': 'application/json',
                    'Authorization': 'Bearer ' + localStorage.getItem('token')
                }
            });
            this.showeditUserModal = false;
        },
  },
};
</script>