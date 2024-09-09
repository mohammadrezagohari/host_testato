import {getDownloadLinkFile} from "../api/version";
import {useQuery} from "react-query";


export const fetchDownloadApp = () => {
    const {data, isLoading, isError} = useQuery(["download-last-version-app"], () => getDownloadLinkFile())
    return {"downloadData": data, "downloadIsLoading": isLoading, "downloadIsError": isError}
}
