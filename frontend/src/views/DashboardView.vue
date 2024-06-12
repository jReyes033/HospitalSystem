<template>
  <div class="row">
    <!-- Side Panel -->
    <div class="col-md-3">
      <nav class="custom-sidebar d-flex flex-column justify-content-between">
        <div>
          <div class="sidebar-header">
            <h3 class="text-uppercase">Dashboard</h3>
          </div>
          <ul class="nav flex-column">
            <li class="nav-item">
              <router-link v-if="isAdmin" class="nav-link" to="/doctors">Doctor Management</router-link>
            </li>
            <li class="nav-item">
              <router-link v-if="isAdmin" class="nav-link" to="/patients">Patient Management</router-link>
            </li>
            <li class="nav-item">
              <router-link v-if="isAdmin" class="nav-link" to="/appointments">Appointment Management</router-link>
            </li>
            <li class="nav-item">
              <router-link v-if="isAdmin" class="nav-link" to="/medicalrecords">Medical Record Management</router-link>
            </li>
            <li class="nav-item">
              <router-link v-if="isAdmin" class="nav-link" to="/users">Admin View</router-link>
            </li>
            <li class="nav-item">
              <router-link v-if="isDoctor" class="nav-link" to="/patients">My Patients</router-link>
            </li>
            <li class="nav-item">
              <router-link v-if="isDoctor || isPatient" class="nav-link" to="/appointments">My Appointments</router-link>
            </li>
            <li class="nav-item">
              <router-link v-if="isDoctor || isPatient" class="nav-link" to="/medicalrecords">My Medical Records</router-link>
            </li>
          </ul>
        </div>
        <div>
          <button v-if="isDoctor || isAdmin" type="submit" class="btn btn-primary m-1" @click="viewprofile()">My Profile</button>
          <router-link v-if="isDoctor || isAdmin" class="btn btn-secondary m-1" to="/logout">Logout</router-link>
          <router-link v-if="isPatient" class="btn btn-secondary m-1 mt-auto" to="/logout">Logout</router-link>
        </div>
      </nav>
    </div>
    <!-- Main Content -->
    <div class="col-md-9">
      <router-view />
    </div>
  </div>

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
        <div class="form-group" v-if="isAdmin">
          <label for="userType">User Type:</label>
          <select class="form-control" id="userType" v-model="editUserData.userType" required>
            <option value="admin">Administrator</option>
            <option value="doctor">Doctor</option>
          </select>
        </div>        
        <button type="submit" class="btn btn-primary m-1">Update</button>
      </form>
    </template>
  </Modal>
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

<style scoped>
.custom-sidebar {
  position: fixed;
  top: 0;
  bottom: 0;
  left: 0;
  z-index: 100;
  padding: 20px;
  overflow-x: hidden;
  overflow-y: auto;
  background-color: #343a40;
  color: #fff;
}
.custom-sidebar .sidebar-header {
  padding: 20px;
  text-align: center;
}
.custom-sidebar h3 {
  margin-bottom: 0;
  font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
  font-weight: bold;
}
.custom-sidebar .nav-link {
  color: rgba(255, 255, 255, 0.75);
  font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
}
.custom-sidebar .nav-link:hover {
  color: #fff;
  background-color: rgba(255, 255, 255, 0.1);
}
.custom-sidebar .btn-primary {
  width: 100%;
  font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
}
.custom-sidebar .btn-secondary {
  width: 100%;
  font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
}
.custom-sidebar .mt-auto {
  margin-top: auto;
}
</style>
