const BASE_URL = `blogs`;
export default {
    store(formValue) {
        return axios.post(`${BASE_URL}`, formValue);
    },
    show(id) {
        return axios.get(`${BASE_URL}/${id}`);
    },
    update(formValue) {
        return axios.post(`${BASE_URL}/update`, formValue);
    },
    getCategories() {
        return axios.get(`${BASE_URL}/categories`);
    },
    getRecentBlogs() {
        return axios.get(`${BASE_URL}/recent`);
    },
    getBlogs(pageNo, pageSize, userId, categoryId) {
        return axios.get(`${BASE_URL}?
        page=${pageNo}
        &page_size=${pageSize}
        &user_id=${userId ? userId : ""}
        &category_id=${categoryId ? categoryId : ""}`
        );
    },
    getUsers(page, page_size) {
        return axios.get(`${BASE_URL}/users?page=${page}&page_size=${page_size}`);
    },
    getLatestUsers() {
        return axios.get(`${BASE_URL}/latest-users`);
    },
}