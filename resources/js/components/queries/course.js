import {useQuery} from "react-query";
import { fetchCourseWithCount} from "../api/course";

export const fetchCourseData = () => {
    const {data, isLoading, isError} =
        useQuery(["get-course-count"], () => fetchCourseWithCount())
    return {"courseData": data, "courseIsLoading": isLoading, "courseIsError": isError}
}
