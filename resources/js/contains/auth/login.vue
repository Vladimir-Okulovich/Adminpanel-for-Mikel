<script>
import appConfig from "@/app.config";
import {mapActions, mapGetters} from 'vuex'
/**
 * Login component
 */
export default {
  page: {
    title: "Login",
    meta: [{ name: "description", content: appConfig.description }]
  },
  components: {},
  data() {
    return {
      email: "",
      password: "",
      authError: null,
      tryingToLogIn: false,
      isAuthError: false
    };
  },
  computed: {
    ...mapGetters([
      'currentRole',
    ]),
  },
  methods: {
    ...mapActions([
      'login'
    ]),
    // Try to log the user in with the username
    // and password they provided.
    tryToLogIn() {
      this.tryingToLogIn = true;
      // Reset the authError if it existed.
      this.authError = null;
      return (
        this.login({
            email: this.email,
            password: this.password
          })
          .then((res) => {
            console.log(this.currentRole)
            if (this.currentRole == 'Admin') {
              this.$router.push({name: "Users"});
            } else if (this.currentRole == 'Judge') {
              this.$router.push({name: "Judge"});
            } else {
              this.$router.push({name: "Home"});
            }
            this.tryingToLogIn = false;
            this.isAuthError = false;
          })
          .catch(error => {
            this.tryingToLogIn = false;
            this.authError = error ? error : "";
            this.isAuthError = true;
          })
      );
    }
  }
};
</script>

<template>
  <div class="account-pages my-5 pt-5">
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6 col-xl-5">
          <div class="card overflow-hidden">
            <div class="bg-primary">
              <div class="text-primary text-center p-4">
                <h5 class="text-white font-size-20">Welcome Back !</h5>
                <p class="text-white-50">Sign in to continue.</p>
                <a href="/" class="logo logo-admin">
                  <img src="@/assets/images/logo-sm.png" height="24" alt="logo" />
                </a>
              </div>
            </div>
            <div class="card-body p-4">
              <div class="p-3">
                <b-alert
                  v-model="isAuthError"
                  variant="danger"
                  class="mt-3"
                  dismissible
                >{{authError}}</b-alert>

                <b-form @submit.prevent="tryToLogIn" class="form-horizontal mt-4">
                  <b-form-group id="input-group-1" label="Email" label-for="input-1">
                    <b-form-input
                      id="input-1"
                      v-model="email"
                      type="email"
                      placeholder="Enter email"
                    ></b-form-input>
                  </b-form-group>

                  <b-form-group
                    id="input-group-2"
                    label="Password"
                    label-for="input-2"
                    class="mb-3"
                  >
                    <b-form-input
                      id="input-2"
                      v-model="password"
                      type="password"
                      placeholder="Enter password"
                    ></b-form-input>
                  </b-form-group>

                  <div class="form-group row">
                    <div class="col-sm-6">
                      <b-form-checkbox
                        id="checkbox-1"
                        name="checkbox-1"
                        value="accepted"
                        unchecked-value="not_accepted"
                      >Remember me</b-form-checkbox>
                    </div>
                    <div class="col-sm-6 text-right">
                      <b-button type="submit" variant="primary" class="w-md">Log In</b-button>
                    </div>
                  </div>

                  <div class="form-group mt-2 mb-0 row">
                    <div class="col-12 mt-4">
                      <router-link tag="a" to="/forgot-password">
                        <i class="mdi mdi-lock"></i> Forgot your password?
                      </router-link>
                    </div>
                  </div>
                </b-form>
              </div>
            </div>
            <!-- end card-body -->
          </div>
          <!-- end card -->
          <div class="mt-5 text-center">
            <p>
              Don't have an account ?
              <router-link tag="a" to="/register" class="font-weight-medium text-primary">Signup now</router-link>
            </p>
            <p class="mb-0">
              ©
              {{new Date().getFullYear()}} 
              <i
                class="mdi mdi-heart text-danger"
              ></i> by Competition Organizer
            </p>
          </div>
        </div>
        <!-- end col -->
      </div>
      <!-- end row -->
    </div>
  </div>
</template>

<style lang="scss" module></style>
