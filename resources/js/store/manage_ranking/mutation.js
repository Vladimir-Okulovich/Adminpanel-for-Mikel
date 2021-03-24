import type from './type'
import JwtService from '@/common/jwt.service'

const mutations = {
  [type.SET_ALL_CATEGORY_MODALITY] (state, data) {
    state.all_category_modality = data.all_category_modality;
  },
  [type.SET_ALL_RANKING_DATA] (state, data) {
    state.all_ranking_data = data.all_ranking_data;
  },
};
export default mutations;