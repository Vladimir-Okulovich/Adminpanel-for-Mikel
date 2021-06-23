<script>
	import Layout from "../subcomponent/layout";
	import appConfig from "@/app.config";
  import PageHeader from "@/components/page-header";

  import { mapActions, mapGetters } from 'vuex';

	export default {
		page: {
        title: "Datos Manga",
        meta: [{ name: "description", content: appConfig.description }]
    },
    components: {
      Layout,
      PageHeader,
    },
    data() {
      return {
        competitionId: 0,
        categoryId: 0,
        modalityId: 0,
        round: 0,
        heat: 0,
      }
    },
    watch: {
      
    },
    computed: {
      ...mapGetters([
        'round_heats',
        'heat_scores',
      ]),
    },
    mounted() {
      this.competitionId = this.$route.params.competitionId;
      this.categoryId = this.$route.params.categoryId;
      this.modalityId = this.$route.params.modalityId;
      this.round = this.$route.params.round;
      this.heat = this.$route.params.heat;
      this.initHeatDetails({
        competitionId: this.competitionId,
        categoryId: this.categoryId,
        modalityId: this.modalityId,
        round: this.round,
        heat: this.heat,
      });
    },
    methods: {
      ...mapActions([
        'initHeatDetails',
        'storeFinalHeatResults',
      ]),

      drawHandler() {
        this.round_heats.forEach(function(round_heat) {
          if (round_heat.draw > 2) {
            round_heat.draw = 2;
          }
          round_heat.points = round_heat.first_score + round_heat.second_score + round_heat.draw/100;
        })
      },
      averageHandler() {
        // console.log(this.heat_scores)
        this.heat_scores.forEach(function(heat_score) {
          for (var i = 1; i < 11; i++) {
            heat_score[3]['wave_'+i] = 0;
            for (var j = 0; j < 3; j++) {
              heat_score[3]['wave_'+i] += heat_score[j]['wave_'+i]/3; 
            }
          }
        })
      },
      saveResults() {
        this.storeFinalHeatResults({
          heat_scores: this.heat_scores,
          round_heats: this.round_heats,
          status: "save",
        })
        .then(() => {
          window.location.reload();
        });
      },
      closeResults() {
        this.storeFinalHeatResults({
          heat_scores: this.heat_scores,
          round_heats: this.round_heats,
          status: "close",
        })
        .then(() => {
          this.$router.go(-1);
        });
      }
    }
	};
</script>
<template>
  <Layout>
    <div class="d-flex justify-content-center pt-4">
      <b-img
        :src="'/images/logo.png'"
        height="127"
        alt="logo"
      ></b-img>
      <div class="w-50" style="border: 1px solid #64676f;">
        <h4 class="mb-0 text-center" style="border-bottom: 1px solid #64676f;padding: 5px 20px;">{{ round_heats[0].com_cat_mod_participant.competition.title }}</h4>
        <p class="mb-0" style="border-bottom: 1px solid #64676f;padding: 3px 20px;">{{ round_heats[0].com_cat_mod_participant.competition.description }}</p>
        <p class="mb-0" style="border-bottom: 1px solid #64676f;padding: 3px 20px;">
          {{ round_heats[0].com_cat_mod_participant.competition.place }}
          {{ round_heats[0].com_cat_mod_participant.competition.date }}
          {{ round_heats[0].com_cat_mod_participant.competition.time }}
        </p>
        <p class="mb-0" style="padding: 3px 20px;">Antolatzailea: {{ round_heats[0].com_cat_mod_participant.competition.organizer }}</p>
      </div>
    </div>

    <div class="text-center w-100 mt-4">
      <h4 style="background: #32394e;padding: 10px 0;">
        {{ round_heats[0].com_cat_mod_participant.category.name }}
        {{ round_heats[0].com_cat_mod_participant.category.sex.name }}
        {{ round_heats[0].com_cat_mod_participant.modality.name }}
        <span style="font-size: 16px;">(Ronda {{ round }} Manga {{ heat }})</span>
      </h4>
    </div>

    <div class="row mt-4">
      <div class="col-lg-8 col-md-9 col-sm-12">
        <div class="table-responsive mb-0">
          <table class="table table-bordered">
            <thead>
              <tr class="thead-light">
                <th>Lycra</th>
                <th>Participante</th>
                <th>Posición</th>
                <th>1ª Mejor Ola</th>
                <th>2ª Mejor Ola</th>
                <th>Pena</th>
                <th>Desempate</th>
                <th>Suma</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="(round_heat, round_heat_index) in round_heats" :key="round_heat_index">
                <th scope="row" v-bind:style="{ background: round_heat.lycra.color }"></th>
                <td>{{ round_heat.com_cat_mod_participant.participant.name+' '+round_heat.com_cat_mod_participant.participant.surname }}</td>
                <td>{{ round_heat.position }}</td>
                <td>{{ parseFloat(round_heat.first_score).toFixed(2) }}</td>
                <td>{{ parseFloat(round_heat.second_score).toFixed(2) }}</td>
                <td><input v-model="round_heat.penal" type="number" step="1" min="0" max="2" class="custom-input" /></td>
                <td><input v-model="round_heat.draw" v-on:change="drawHandler" type="number" step="1" min="0" max="2" class="custom-input" /></td>
                <td>{{ parseFloat(round_heat.points).toFixed(2) }}</td>
              </tr>
            </tbody>
          </table>
          <div class="d-flex justify-content-between my-4">
            <button @click="closeResults"
              class="btn btn-info"
            >
             Terminar Manga
            </button>
            <button @click="saveResults"
              class="btn btn-orange mr-2"
            >
              Guardar Datos
            </button>
          </div>
        </div>
      </div>

      <div class="col-12 mt-4">
        <div class="table-responsive mb-0">
          <table class="table table-bordered table-sm text-center">
            <thead class="thead-light">
              <tr>
                <th rowspan="2">PARTICIPANTE</th>
                <th rowspan="2">JUEZ</th>
                <th colspan="10">OLAS</th>
                <th rowspan="2">Pena</th>
              </tr>
              <tr>
                <th v-for="n in 10" :key="n">{{ n }}</th>
              </tr>
            </thead>
            <tbody v-for="(heat_score, index_1) in heat_scores" :key="index_1">
              <tr v-for="(heat_score_row, index_2) in heat_score" :key="index_2">
                <td rowspan="4" :style="{background: heat_score_row.round_heat.lycra.color}" v-if="index_2==0"></td>
                <td v-if="heat_score_row.judge_id != 'Average'">{{ heat_score_row.judge.name }}</td>
                <td v-else style="background: #0c101d;">{{ heat_score_row.judge_id }}</td>
                <td v-if="heat_score_row.judge_id != 'Average'"><input v-model="heat_score_row.wave_1" v-on:change="averageHandler" type="number" min="0" max="10" step="0.1" class="custom-input" /></td>
                <td v-else style="background: #0c101d;">{{ parseFloat(heat_score_row.wave_1).toFixed(2) }}</td>
                <td v-if="heat_score_row.judge_id != 'Average'"><input v-model="heat_score_row.wave_2" v-on:change="averageHandler" type="number" min="0" max="10" step="0.1" class="custom-input" /></td>
                <td v-else style="background: #0c101d;">{{ parseFloat(heat_score_row.wave_2).toFixed(2) }}</td>
                <td v-if="heat_score_row.judge_id != 'Average'"><input v-model="heat_score_row.wave_3" v-on:change="averageHandler" type="number" min="0" max="10" step="0.1" class="custom-input" /></td>
                <td v-else style="background: #0c101d;">{{ parseFloat(heat_score_row.wave_3).toFixed(2) }}</td>
                <td v-if="heat_score_row.judge_id != 'Average'"><input v-model="heat_score_row.wave_4" v-on:change="averageHandler" type="number" min="0" max="10" step="0.1" class="custom-input" /></td>
                <td v-else style="background: #0c101d;">{{ parseFloat(heat_score_row.wave_4).toFixed(2) }}</td>
                <td v-if="heat_score_row.judge_id != 'Average'"><input v-model="heat_score_row.wave_5" v-on:change="averageHandler" type="number" min="0" max="10" step="0.1" class="custom-input" /></td>
                <td v-else style="background: #0c101d;">{{ parseFloat(heat_score_row.wave_5).toFixed(2) }}</td>
                <td v-if="heat_score_row.judge_id != 'Average'"><input v-model="heat_score_row.wave_6" v-on:change="averageHandler" type="number" min="0" max="10" step="0.1" class="custom-input" /></td>
                <td v-else style="background: #0c101d;">{{ parseFloat(heat_score_row.wave_6).toFixed(2) }}</td>
                <td v-if="heat_score_row.judge_id != 'Average'"><input v-model="heat_score_row.wave_7" v-on:change="averageHandler" type="number" min="0" max="10" step="0.1" class="custom-input" /></td>
                <td v-else style="background: #0c101d;">{{ parseFloat(heat_score_row.wave_7).toFixed(2) }}</td>
                <td v-if="heat_score_row.judge_id != 'Average'"><input v-model="heat_score_row.wave_8" v-on:change="averageHandler" type="number" min="0" max="10" step="0.1" class="custom-input" /></td>
                <td v-else style="background: #0c101d;">{{ parseFloat(heat_score_row.wave_8).toFixed(2) }}</td>
                <td v-if="heat_score_row.judge_id != 'Average'"><input v-model="heat_score_row.wave_9" v-on:change="averageHandler" type="number" min="0" max="10" step="0.1" class="custom-input" /></td>
                <td v-else style="background: #0c101d;">{{ parseFloat(heat_score_row.wave_9).toFixed(2) }}</td>
                <td v-if="heat_score_row.judge_id != 'Average'"><input v-model="heat_score_row.wave_10" v-on:change="averageHandler" type="number" min="0" max="10" step="0.1" class="custom-input" /></td>
                <td v-else style="background: #0c101d;">{{ parseFloat(heat_score_row.wave_10).toFixed(2) }}</td>
                <td v-if="heat_score_row.judge_id != 'Average'">{{ heat_score_row.penal }}</td>
                <td v-else style="background: #0c101d;"></td>
              </tr>
            </tbody>
          </table>
        </div>

        <div class="d-flex justify-content-between my-4">
          <button @click="closeResults"
            class="btn btn-info"
          >
            Terminar Manga
          </button>
          <button @click="saveResults"
            class="btn btn-orange mr-2"
          >
            Guardar Datos
          </button>
        </div>
      </div>
    </div>
  </Layout>
</template>

<style scoped>
  .custom-input {
    background: transparent;
    border: 0;
    color: #a8b2bc;
    text-align: center;
    max-width: 40px;
  }
  .custom-input:focus {
    outline: none;
  }
  input::-webkit-outer-spin-button,
  input::-webkit-inner-spin-button {
    -webkit-appearance: none;
    margin: 0;
  }
  input[type=number] {
    -moz-appearance: textfield;
  }
</style>