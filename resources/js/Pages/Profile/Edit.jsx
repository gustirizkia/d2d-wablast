import { Head } from "@inertiajs/react";
import Layout from "../../Layouts/User";
import UpdatePasswordForm from "./Partials/UpdatePasswordForm";
import UpdateProfileInformationForm from "./Partials/UpdateProfileInformationForm";
import TopUser from "@/Components/TopUser";

export default function Edit({ auth, mustVerifyEmail, status }) {
    return (
        <Layout>
            <Head title="Profile Saya" />
            <div className="bg-green-50 min-h-screen">
                <div className="bg-green-600 h-32 w-full rounded-b-3xl">
                    <TopUser auth={auth} />
                </div>
                <div className="-mt-20 mx-3 rounded-lg pb-32">
                    <div className="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
                        <div className="p-4 sm:p-8 bg-white  rounded-lg">
                            <UpdateProfileInformationForm
                                mustVerifyEmail={mustVerifyEmail}
                                status={status}
                                className="max-w-xl"
                            />
                        </div>

                        <div className="p-4 sm:p-8 bg-white  rounded-lg">
                            <UpdatePasswordForm className="max-w-xl" />
                        </div>
                    </div>
                </div>
            </div>
        </Layout>
    );
}
