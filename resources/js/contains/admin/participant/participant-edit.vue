<script>
import Layout from "../subcomponent/layout";
import PageHeader from "@/components/page-header";
import appConfig from "@/app.config";

import DatePicker from "vue2-datepicker";
import Multiselect from "vue-multiselect";

import { mapActions, mapGetters } from 'vuex';

import {
  required,
  email,
  minLength,
  sameAs,
  maxLength,
  minValue,
  maxValue,
  numeric,
  url,
  alphaNum
} from "vuelidate/lib/validators";

export default {
  page: {
    title: "EDIT PARTICIPANT",
    meta: [{ name: "description", content: appConfig.description }]
  },
  components: { DatePicker, Multiselect, Layout, PageHeader },
  data() {
    return {
      title: "EDIT PARTICIPANT",
      items: [
        {
          text: "Administrator",
          href: "/admin"
        },
        {
          text: "Participant",
          href: "/admin/participants"
        },
        {
          text: "Edit",
          active: true
        }
      ],
      isError: false,
      Error: null,
      typeform: {
        name: "",
        surname: "",
        dni_ficha: "",
        birthday: "",
        sex: "",
        club: "",
      },
      sexOptions: [
        "Male",
        "Female"
      ],
      typesubmit: false,
    };
  },
  validations: {
    typeform: {
      name: { required },
      surname: { required },
      dni_ficha: { required },
      birthday: { required },
      sex: { required },
      club: { required },
    }
  },
  mounted() {
    this.getClubOptions();
    this.getParticipantById(this.$route.params.participantId);
  },
  computed: {
    ...mapGetters([
      'clubOptions',
      'getParticipant',
    ]),
  },
  methods: {
    ...mapActions([
        'updateParticipant',
        'getParticipantById',
        'getClubOptions',
      ]),
    /**
     * Validation type submit
     */
    // eslint-disable-next-line no-unused-vars
    typeForm(e) {
      // console.log(this.typeform.club)
      this.typesubmit = true;
      this.isError = false;
      this.Error = null;
      // stop here if form is invalid
      this.$v.$touch()
      if (this.$v.typeform.name.$error || this.$v.typeform.surname.$error || this.$v.typeform.dni_ficha.$error || this.$v.typeform.birthday.$error || this.$v.typeform.sex.$error || this.$v.typeform.club.$error) {
        return ;
      }
      return (
        this.updateParticipant({
            id: this.getParticipant.id,
            name: this.typeform.name,
            surname: this.typeform.surname,
            dni_ficha: this.typeform.dni_ficha,
            birthday: this.typeform.birthday,
            sex: this.typeform.sex,
            club: this.typeform.club,
          })
          .then((res) => {
            this.$router.push({name: "Participants"});
            this.typesubmit = false;
          })
          .catch(error => {
            this.typesubmit = false;
            this.Error = error ? error : "";
            this.isError = true;
          })
      );
    }
  }
};
</script>

<template>
  <Layout>
    <PageHeader :title="title" :items="items" />

    <div class="row">
      <div class="col-12">
        <div class="card">
          <div class="card-body">
            <b-alert
              v-model="isError"
              variant="danger"
              class="mt-3"
              dismissible
            >{{ Error }}</b-alert>
            <form action="#" @submit.prevent="typeForm">
              <div class="form-group">
                <label>Name</label>
                <input
                  v-model="typeform.name=getParticipant.name"
                  type="text"
                  class="form-control"
                  name="name"
                  :class="{ 'is-invalid': typesubmit && $v.typeform.name.$error }"
                />
                <div v-if="typesubmit && $v.typeform.name.$error" class="invalid-feedback">
                  <span v-if="!$v.typeform.name.required">This value is required.</span>
                </div>
              </div>
              <div class="form-group">
                <label>Surname</label>
                <input
                  v-model="typeform.surname=getParticipant.surname"
                  type="text"
                  class="form-control"
                  name="surname"
                  :class="{ 'is-invalid': typesubmit && $v.typeform.surname.$error }"
                />
                <div v-if="typesubmit && $v.typeform.surname.$error" class="invalid-feedback">
                  <span v-if="!$v.typeform.surname.required">This value is required.</span>
                </div>
              </div>
              <div class="form-group">
                <label>Dni Ficha</label>
                <input
                  v-model="typeform.dni_ficha=getParticipant.dni_ficha"
                  type="text"
                  class="form-control"
                  name="dni_ficha"
                  :class="{ 'is-invalid': typesubmit && $v.typeform.dni_ficha.$error }"
                />
                <div v-if="typesubmit && $v.typeform.dni_ficha.$error" class="invalid-feedback">
                  <span v-if="!$v.typeform.dni_ficha.required">This value is required.</span>
                </div>
              </div>
              <div class="form-group mb-3">
                <label>Birthday</label>
                <br />
                <date-picker
                  v-model="typeform.birthday=getParticipant.birthday"
                  format="DD-MM-YYYY"
                  value-type="format"
                  :first-day-of-week="1"
                  lang="en"
                  placeholder="DD-MM-YYYY"
                  :class="{ 'is-invalid': typesubmit && $v.typeform.birthday.$error }"
                ></date-picker>
                <div v-if="typesubmit && $v.typeform.birthday.$error" class="invalid-feedback">
                  <span v-if="!$v.typeform.birthday.required">This value is required.</span>
                </div>
              </div>
              <div>
                <label>Sex</label>
                <multiselect 
                  v-model="typeform.sex=getParticipant.sex.name" 
                  :options="sexOptions"
                  :class="{ 'is-invalid': typesubmit && $v.typeform.sex.$error }"
                ></multiselect>
                <div v-if="typesubmit && $v.typeform.sex.$error" class="invalid-feedback">
                  <span v-if="!$v.typeform.sex.required">This value is required.</span>
                </div>
              </div>
              <br />
              <div>
                <label>Club</label>
                <multiselect 
                  v-model="typeform.club=getParticipant.club.name"
                  :options="clubOptions"
                  :class="{ 'is-invalid': typesubmit && $v.typeform.club.$error }"  
                ></multiselect>
                <div v-if="typesubmit && $v.typeform.club.$error" class="invalid-feedback">
                  <span v-if="!$v.typeform.club.required">This value is required.</span>
                </div>
              </div>
              <div class="form-group mt-5 mb-0">
                <div>
                  <button type="submit" class="btn btn-primary">Submit</button>
                  <router-link to="/admin/participants" class="btn btn-secondary m-l-5 ml-1">Cancel</router-link>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </Layout>
</template>