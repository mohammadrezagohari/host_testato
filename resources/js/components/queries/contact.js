import {useQuery} from "react-query";
import {getContactInfo} from "../api/contact";

export const fetchContactData = () => {
    const {data, isLoading, isError} = useQuery(["get-contact-list"], () => getContactInfo())
    return {"contactData": data, "contactIsLoading": isLoading, "contactIsError": isError}
}
