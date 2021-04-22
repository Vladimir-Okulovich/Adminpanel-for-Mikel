<script>
	import Layout from "../subcomponent/layout";
	import appConfig from "@/app.config";
  import PageHeader from "@/components/page-header";

  import { mapActions, mapGetters } from 'vuex';

	export default {
		page: {
        title: "Competition Heats",
        meta: [{ name: "description", content: appConfig.description }]
    },
    components: {
      Layout,
      PageHeader,
    },
    data() {
      return {
        
      }
    },
    watch: {
      
    },
    computed: {
      ...mapGetters([

      ]),
    },
    mounted() {

    },
    methods: {
      ...mapActions([

      ]),
    }
	};
</script>
<template>
  <Layout>
    <div class="row">
      <h3 class="my-4 col-12">FIRST ROUND</h3>
      <div class="col-lg-4 col-md-6 col-sm-6">
        <div class="table-responsive mb-0">
          <table class="table table-bordered">
            <thead>
              <tr>
                <th colspan="4">ROUND 1 HEAT 1</th>
              </tr>
              <tr>
                <th></th>
                <th>Participant</th>
                <th>Points</th>
                <th>Position</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <th scope="row">1</th>
                <td>Mark</td>
                <td>1</td>
                <td>1</td>
              </tr>
              <tr>
                <th scope="row">2</th>
                <td>Jacob</td>
                <td>1</td>
                <td>1</td>
              </tr>
              <tr>
                <th scope="row">3</th>
                <td>Larry</td>
                <td>1</td>
                <td>1</td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
    <b-modal
      id="delete-modal"
      centered
      title="Delete Item"
      title-class="font-18"
      hide-footer
    >
      <p>Do you really want to delete this participant?</p>
      <footer id="delete-modal___BV_modal_footer_" class="modal-footer">
        <button type="button" class="btn btn-secondary" @click="$bvModal.hide('delete-modal')">Cancel</button>
        <button type="button" class="btn btn-primary" @click="realDelete()">OK</button>
      </footer>
    </b-modal>
  </Layout>
</template>

<style>
</style>