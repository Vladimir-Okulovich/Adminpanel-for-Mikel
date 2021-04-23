import type from './type'
import JwtService from '@/common/jwt.service'

const mutations = {
  [type.SET_PARTICIPANTS_COMPETITION_CATEGORY_MODALITY] (state, data) {
    state.participants_competition_category_modality = data.participants_competition_category_modality;
    state.category_id = data.category_id;
    state.modality_id = data.modality_id;
  },
  [type.GET_ALL_ROUND_HEATS] (state, data) {
    state.all_round_heats = data.all_round_heats;
  },
  [type.GET_ROUND_HEAT_DETAILS] (state, data) {
    state.round_heats = data.round_heats;
  },
};
export default mutations;