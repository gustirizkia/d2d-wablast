import { Head } from "@inertiajs/react";
import React from "react";
import Layout from "../Layouts/User";
import TopUser from "@/Components/TopUser";

export default function Home({ auth }) {
    return (
        <Layout>
            <Head title="Home" />
            <div className="bg-yellow-600 h-32 w-full rounded-b-3xl">
                <TopUser auth={auth} />
            </div>
            <div className="mx-3 -mt-20">
                <img
                    src="https://t3.ftcdn.net/jpg/03/50/57/66/360_F_350576696_0CN9vmhjQfC8tmjkv1u911carwErMJ3D.webp"
                    className="rounded"
                    alt=""
                />
            </div>
        </Layout>
    );
}
