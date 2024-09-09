import baseApi from "./base";

export const getDownloadLinkFile = async () => {
    const response = await baseApi.get("version/latest/download", {
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
