import baseApi from "./base";
export const fetchCourseWithCount = async () => {
    const response = await baseApi.get("course/list-with-count/", {
        headers: {
            "Content-Type": "application/json",
            Accept: "application/json",
        }
    });
    if (response?.status === 200) {
        return response?.data;
    }
    return null;
}
