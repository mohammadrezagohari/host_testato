import baseApi from "./base";

export const getContactInfo = async () => {
    const response = await baseApi.get("contact/latest", {
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
