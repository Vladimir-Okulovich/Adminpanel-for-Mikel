import type from './type'
import JwtService from '@/common/jwt.service'

const mutations = {
  [type.SET_PARTICIPANTS_COMPETITION_CATEGORY_MODALITY] (state, data) {
    state.participants_competition_category_modality = data.participants_competition_category_modality;
    state.category_id = data.category_id;
    state.modality_id = data.modality_id;
  },
};
export default mutations;