import React, { useEffect } from "react";
import Layout from "../Layouts/User";
import { Head, Link, router } from "@inertiajs/react";
import TopUser from "@/Components/TopUser";

export default function ListQuiz({ data_target, count_soal, auth }) {
    return (
        <Layout>
            <Head title="Survey Saya" />
            <div className="bg-blue-50 min-h-screen">
                <div className="bg-yellow-600 h-32 w-full rounded-b-3xl">
                    <TopUser auth={auth} />
                </div>
                <div className="mx-3 p-3 rounded-lg -mt-20 bg-white mb-3">
                    <div className="">
                        <div className="font-semibold text-xs text-gray-600">
                            Total Survey
                        </div>
                        <div className="text-yellow-700 text-xl">
                            {data_target.length}
                        </div>
                    </div>
                    <div className="mt-2  ">
                        <Link
                            href="/survey"
                            className="bg-yellow-600 py-2 rounded px-2 inline-block text-xs text-white mx-auto cursor-pointer"
                        >
                            Survey Baru
                        </Link>
                    </div>
                    <div className="md:w-1/3 relative"></div>
                </div>
                {data_target.map((item, index) => {
                    return (
                        <div
                            className="mx-3 border mb-3 p-3 rounded-lg bg-white block"
                            key={index}
                        >
                            <div className="font-semibold">{item.nama}</div>
                            <div className="text-gray-500 text-xs">
                                {item.alamat}
                            </div>
                            <div className="flex justify-between mt-4">
                                <div className="flex">
                                    <div className="text-white bg-yellow-600 inline-block py-1 px-5 rounded text-xs ">
                                        Edit
                                    </div>
                                </div>
                                {item.foto_bersama === null ? (
                                    <Link
                                        href={`quiz/${item.id}`}
                                        className="text-gray-500 bg-yellow-200 inline-block py-1 px-5 rounded text-xs text-right"
                                    >
                                        Lanjut
                                    </Link>
                                ) : (
                                    <div className="text-white bg-yellow-600 inline-block py-1 px-5 rounded text-xs text-right">
                                        {item.pilihan_target_count} Selesai
                                    </div>
                                )}
                            </div>
                        </div>
                    );
                })}
            </div>
        </Layout>
    );
}
