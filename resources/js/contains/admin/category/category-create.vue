<script>
import Layout from "../subcomponent/layout";
import PageHeader from "@/components/page-header";
import appConfig from "@/app.config";

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
    title: "ADD CATEGORY",
    meta: [{ name: "description", content: appConfig.description }]
  },
  components: { Multiselect, Layout, PageHeader },
  data() {
    return {
      title: "ADD CATEGORY",
      items: [
        {
          text: "Administrator",
          href: "/"
        },
        {
          text: "Competition Data",
          active: true
        },
        {
          text: "Category",
          href: "/admin/categories"
        },
        {
          text: "Add",
          active: true
        }
      ],
      sexOptions: [
        "Female",
        "Male"
      ],
      minValue: true,
      isError: false,
      Error: null,
      typeform: {
        name: "",
        description: "",
        year1: 0,
        year2: 0,
        sex: "",
      },
      typesubmit: false,
    };
  },
  validations: {
    typeform: {
      name: { required },
      description: { required },
      year1: { required },
      year2: { required },
      sex: { required },
    }
  },
  methods: {
    ...mapActions([
        'createCategory'
      ]),
    /**
     * Validation type submit
     */
    // eslint-disable-next-line no-unused-vars
    typeForm(e) {
      this.typesubmit = true;
      this.isError = false;
      this.Error = null;
      if (this.typeform.year1 >= this.typeform.year2) {
        this.minValue = false;
      } else {
        this.minValue = true;
      }
      // stop here if form is invalid
      this.$v.$touch()
      if (!this.minValue || this.$v.typeform.name.$error || this.$v.typeform.description.$error || this.$v.typeform.year1.$error || this.$v.typeform.year2.$error || this.$v.typeform.sex.$error) {
        return ;
      }
      return (
        this.createCategory({
            name: this.typeform.name,
            description: this.typeform.description,
            year1: this.typeform.year1,
            year2: this.typeform.year2,
            sex: this.typeform.sex,
          })
          .then((res) => {
            this.$router.push({name: "Categories"});
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
                  v-model="typeform.name"
                  type="text"
                  class="form-control"
                  placeholder="Name"
                  name="name"
                  :class="{ 'is-invalid': typesubmit && $v.typeform.name.$error }"
                />
                <div v-if="typesubmit && $v.typeform.name.$error" class="invalid-feedback">
                  <span v-if="!$v.typeform.name.required">This value is required.</span>
                </div>
              </div>
              <div class="form-group">
                <label>Description</label>
                <div>
                  <textarea
                    v-model="typeform.description"
                    class="form-control"
                    name="description"
                    :style="{ 'min-height': '100px' }"
                    :class="{ 'is-invalid': typesubmit && $v.typeform.description.$error }"
                  ></textarea>
                  <div v-if="typesubmit && $v.typeform.description.$error" class="invalid-feedback">
                    <span v-if="!$v.typeform.description.required">This value is required.</span>
                  </div>
                </div>
              </div>
              <div class="form-group">
                <label>Year1</label>
                <input
                  v-model="typeform.year1"
                  type="number"
                  class="form-control"
                  placeholder="Min year"
                  name="year1"
                  :class="{ 'is-invalid': typesubmit && $v.typeform.year1.$error }"
                />
                <div v-if="typesubmit && $v.typeform.year1.$error" class="invalid-feedback">
                  <span v-if="!$v.typeform.year1.required">This value is required.</span>
                </div>
              </div>
              <div class="form-group">
                <label>Year2</label>
                <input
                  v-model="typeform.year2"
                  type="number"
                  class="form-control"
                  placeholder="Max year"
                  name="year2"
                  :class="{ 'is-invalid': typesubmit && ($v.typeform.year2.$error || !minValue) }"
                />
                <div v-if="typesubmit && ($v.typeform.year2.$error || !minValue)" class="invalid-feedback">
                  <span v-if="!$v.typeform.year2.required">This value is required.</span>
                  <span
                      v-if="!minValue"
                    >This value should be greater than Year1.</span>
                </div>
              </div>
              <div class="mb-3">
                <label>Sex</label>
                <multiselect 
                  v-model="typeform.sex" 
                  :options="sexOptions"
                  :class="{ 'is-invalid': typesubmit && $v.typeform.sex.$error }"
                ></multiselect>
                <div v-if="typesubmit && $v.typeform.sex.$error" class="invalid-feedback">
                  <span v-if="!$v.typeform.sex.required">This value is required.</span>
                </div>
              </div>
              <div class="form-group mt-5 mb-0">
                <div>
                  <button type="submit" class="btn btn-primary">Submit</button>
                  <router-link to="/admin/categories" class="btn btn-secondary m-l-5 ml-1">Cancel</router-link>
                  <button type="reset" class="btn btn-warning m-l-5 ml-1">Reset</button>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </Layout>
</template>