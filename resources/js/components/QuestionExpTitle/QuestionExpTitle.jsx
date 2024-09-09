import React from "react";
import QuestionTitles from "./QusetionTitles";
import {ThreeDots} from "react-loader-spinner";
import {fetchCourseData} from "../queries/course";

const QuestionExpTitle = () => {
    const {courseData, courseIsError, courseIsLoading} = fetchCourseData();

    if (courseIsLoading) {
        return (<div className="flex items-center justify-center py-60">
            <ThreeDots
                height="80"
                width="80"
                radius="9"
                color="#4fa94d"
                ariaLabel="three-dots-loading"
                wrapperStyle={{}}
                wrapperClassName=""
                visible={true}
            />
        </div>)
    }

    return (
        <section
            className="flex w-full h-max flex-row   QE-titles-container items-center justify-between lg:p-14 md:p-14 p-4 bg-mainclr">
            {
                courseData?.data.map((course) => (
                    <QuestionTitles key={course.id} count={course?.question_count}>{course?.title}</QuestionTitles>
                ))
            }
        </section>
    );

}
export default QuestionExpTitle;
