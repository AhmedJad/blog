const BASE_URL = `blogs/comments`;
export default {
    createComment(formValue) {
        return axios.post(`${BASE_URL}`, formValue);
    },
    getComments(page, pageSize, blogId) {
        return axios.get(`${BASE_URL}/${blogId}?page=${page}&page_size=${pageSize}`);
    },
    deleteComment(id) {
        return axios.delete(`${BASE_URL}/${id}`);
    }
}