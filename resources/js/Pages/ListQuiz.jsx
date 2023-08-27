import React, { useEffect, useState } from "react";
import Layout from "../Layouts/User";
import { Head, Link, router } from "@inertiajs/react";
import TopUser from "@/Components/TopUser";
import ListTargetKota from "@/Components/Modal/ListTargetKota";

export default function ListQuiz({ data_target, auth, listKota }) {
    const [ModalShow, SetModalShow] = useState(true);

    useEffect(() => {
        if (listKota.length === 0) {
            SetModalShow(false);
        }
    }, []);

    return (
        <Layout>
            <Head title="Survey Saya" />
            <div className="bg-blue-50 min-h-screen pb-32">
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
                    {listKota.length !== 0 && (
                        <div className="mt-2  ">
                            <div
                                onClick={() => SetModalShow(true)}
                                className="bg-yellow-600 py-2 rounded px-2 inline-block text-xs text-white mx-auto cursor-pointer"
                            >
                                Survey Baru
                            </div>
                        </div>
                    )}
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
                                        href={`/quiz/data/${item.id}`}
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

            {/* modal */}
            {ModalShow && (
                <div
                    onClick={() => {
                        if (ModalShow) {
                            SetModalShow(false);
                        } else {
                            SetModalShow(true);
                        }
                    }}
                    className="bg-gray-800 md:px-0 px-3 bg-opacity-75 transition-opacity min-h-screen w-full fixed top-0 right-0 flex items-center justify-center "
                >
                    <div className="bg-white md:w-1/2 w-full  p-3 rounded-lg transition duration-150 ease-in-out">
                        <div className="font-semibold">Pilih Kota Survey</div>

                        <div className="mt-4">
                            {listKota.map((item) => {
                                return (
                                    <div
                                        className="mb-3 border p-2 rounded-lg"
                                        key={item.id}
                                    >
                                        <Link
                                            href={`/survey?kota=${item.kota_id}`}
                                        >
                                            <div className="flex items-center justify-between">
                                                <div className="">
                                                    {item.kota.nama}
                                                </div>
                                                <div className="">
                                                    <svg
                                                        xmlns="http://www.w3.org/2000/svg"
                                                        fill="none"
                                                        viewBox="0 0 24 24"
                                                        strokeWidth={1.5}
                                                        stroke="currentColor"
                                                        className="w-6 h-6"
                                                    >
                                                        <path
                                                            strokeLinecap="round"
                                                            strokeLinejoin="round"
                                                            d="M8.25 4.5l7.5 7.5-7.5 7.5"
                                                        />
                                                    </svg>
                                                </div>
                                            </div>
                                        </Link>
                                    </div>
                                );
                            })}
                        </div>
                    </div>
                </div>
            )}

            {/* modal end */}
        </Layout>
    );
}
