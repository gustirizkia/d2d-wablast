import React, { useEffect, useState } from "react";
import Layout from "../Layouts/User";
import { Head, Link, router, useForm } from "@inertiajs/react";
import Swal from "sweetalert2";
import axios from "axios";
import LoadingPage from "@/Components/LoadingPage";

export default function Quiz({
    target,
    soal,
    is_last_soal,
    csrf_token,
    is_first_soal,
}) {
    const [TempSoal, SetTempSoal] = useState(soal);
    const [TempLastSoal, SetTempLastSoal] = useState(is_last_soal);
    const [FirstSoal, SetFirstSoal] = useState(is_first_soal);
    const [PilihanId, SetPilihanId] = useState(0);
    const [LoadingUp, SetLoadingUp] = useState(false);

    const handelNext = () => {
        if (PilihanId === 0) {
            Swal.fire("Info!", "Pilih jawaban ", "info");
        } else {
            SetLoadingUp(true);
            let formData = {
                soal_id: TempSoal.id,
                target_id: target.id,
                pilihan_id: PilihanId,
            };
            formData._token = csrf_token;
            axios
                .post("/nextSoal", formData)
                .then((ress) => {
                    SetTempSoal(ress.data.next_soal);
                    SetTempLastSoal(ress.data.is_last_soal);

                    if (ress.data.riwayatPilihan) {
                        SetPilihanId(ress.data.riwayatPilihan.pilihan_ganda_id);
                    } else {
                        SetPilihanId(0);
                    }

                    SetLoadingUp(false);
                })
                .catch((err) => {
                    SetLoadingUp(false);
                    console.log("err", err);
                });
        }
    };

    const handleSelesai = () => {
        console.log("PilihanId", PilihanId);
        if (PilihanId === 0) {
            Swal.fire("Info!", "Pilih jawaban ", "info");
        } else {
            SetLoadingUp(true);
            let formData = {
                soal_id: TempSoal.id,
                target_id: target.id,
                pilihan_id: PilihanId,
            };
            formData._token = csrf_token;
            axios
                .post("/nextSoal", formData)
                .then((ress) => {
                    Swal.fire({
                        icon: "success",
                        title: "Anda telah menyelesaikan survey",
                    });
                    router.get("/list-survey");
                    SetLoadingUp(false);
                })
                .catch((err) => {
                    SetLoadingUp(false);
                    console.log("err", err);
                });
        }
    };

    const handleBackSoal = () => {
        SetLoadingUp(true);

        axios
            .get(`/backSoal?soal_id=${TempSoal.id}&target_id=${target.id}`)
            .then((ress) => {
                SetTempSoal(ress.data.soal);
                SetPilihanId(ress.data.pilihanUser.pilihan_ganda_id);
                SetFirstSoal(ress.data.first_soal);
                SetTempLastSoal(false);
                SetLoadingUp(false);
            })
            .catch((err) => {
                SetLoadingUp(false);
                console.log("err", err);
            });
    };

    return (
        <Layout>
            <Head title={`Pertanyaan ${TempSoal.title}`} />
            {/* Loading */}
            {LoadingUp && <LoadingPage />}
            {/* Loading end*/}
            <div className="bg-green-50 min-h-screen">
                <div className="bg-green-600 h-36 w-full rounded-b-3xl">
                    <Link href="/" className="flex items-center px-3 pt-2">
                        <div className="text-white">
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
                                    d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18"
                                />
                            </svg>
                        </div>
                        <div className="text-white ml-3">Home</div>
                    </Link>
                </div>
                <div className="bg-white p-3 rounded-lg -mt-24 mx-3">
                    <div className="text-lg font-semibold">
                        {TempSoal.title}
                    </div>
                    <div className="text-sm">{TempSoal.subtitle}</div>
                </div>
                <div className="bg-white p-3 rounded-lg  mx-3 mt-2">
                    {TempSoal.pilihan.map((item, index) => {
                        return (
                            <div
                                className={`p-3 rounded-full mb-3 border flex items-center ${
                                    PilihanId === item.id
                                        ? "bg-green-500 text-white  border-green-500 "
                                        : "bg-green-100 border-green-100"
                                }`}
                                key={item.id}
                                onClick={() => SetPilihanId(item.id)}
                            >
                                {PilihanId === item.id && (
                                    <div className="mr-2">
                                        <svg
                                            xmlns="http://www.w3.org/2000/svg"
                                            viewBox="0 0 24 24"
                                            fill="currentColor"
                                            className="w-6 h-6"
                                        >
                                            <path
                                                fillRule="evenodd"
                                                d="M2.25 12c0-5.385 4.365-9.75 9.75-9.75s9.75 4.365 9.75 9.75-4.365 9.75-9.75 9.75S2.25 17.385 2.25 12zm13.36-1.814a.75.75 0 10-1.22-.872l-3.236 4.53L9.53 12.22a.75.75 0 00-1.06 1.06l2.25 2.25a.75.75 0 001.14-.094l3.75-5.25z"
                                                clipRule="evenodd"
                                            />
                                        </svg>
                                    </div>
                                )}
                                <span className="mr-2 text-sm">
                                    {index + 1}.
                                </span>
                                <span className="text-sm">{item.title}</span>
                            </div>
                        );
                    })}
                    {TempLastSoal ? (
                        <>
                            <div
                                onClick={handleSelesai}
                                className=" bg-green-600 text-white text-center px-2 py-3 rounded-full w-full mt-10"
                            >
                                Selesai
                            </div>
                            <div
                                onClick={handleBackSoal}
                                className=" bg-gray-600 w-full mt-4 text-white text-center px-2 py-3 rounded-full "
                            >
                                Back
                            </div>
                        </>
                    ) : (
                        <div className="flex justify-between mt-16">
                            {FirstSoal ? (
                                <div
                                    onClick={() => router.get("/list-survey")}
                                    className=" bg-gray-600 text-white text-center px-2 py-3 rounded-full w-1/3"
                                >
                                    Back Home
                                </div>
                            ) : (
                                <div
                                    onClick={handleBackSoal}
                                    className=" bg-gray-600 text-white text-center px-2 py-3 rounded-full w-1/3"
                                >
                                    Back
                                </div>
                            )}
                            <div
                                onClick={handelNext}
                                className=" bg-green-600 text-white text-center px-2 py-3 rounded-full w-1/2"
                            >
                                Selanjutnya
                            </div>
                        </div>
                    )}
                </div>
            </div>
        </Layout>
    );
}
