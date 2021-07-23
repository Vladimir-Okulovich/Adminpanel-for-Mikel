import mutations from './mutation'
import actions from './action'
import getters from './getter'
import JwtService from "@/common/jwt.service"

const defaultState = {
  category_modality_with_part: [],
  participants_competition_category_modality: [],
  category_id: 0,
  competition: {},
  category_status: 0,
  modality_id: 0,
  all_round_heats: [],
  round_heats: [],
  heat_scores: [],
  all_home_round_heats: [],
  deleteStatus: null,
};

export default {
  state: defaultState,
  getters,
  actions,
  mutations,
};
