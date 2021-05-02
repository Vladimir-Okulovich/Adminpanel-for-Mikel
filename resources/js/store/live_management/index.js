import mutations from './mutation'
import actions from './action'
import getters from './getter'
import JwtService from "@/common/jwt.service"

const defaultState = {
  category_modality_with_part: [],
  participants_competition_category_modality: [],
  category_id: 0,
  category_status: false,
  modality_id: 0,
  all_round_heats: [],
  round_heats: [],
  heat_scores: [],

  all_home_round_heats: [],
};

export default {
  state: defaultState,
  getters,
  actions,
  mutations,
};
