import React, { useEffect, useRef, useState } from "react";
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
    const [FotoBersama, SetFotoBersama] = useState(null);
    const [PreviewImage, SetPreviewImage] = useState(null);
    const [YesNo, SetYesNo] = useState(null);

    const inputRef = useRef(null);

    const handelNext = () => {
        if (PilihanId === 0 && parseInt(TempSoal.yes_no) !== 1) {
            Swal.fire("Info!", "Pilih jawaban ", "info");
        } else if (!YesNo && parseInt(TempSoal.yes_no) === 1) {
            Swal.fire("Info!", "Pilih jawaban ya atau tidak", "info");
        } else {
            SetLoadingUp(true);
            let formData = {
                soal_id: TempSoal.id,
                target_id: target.id,
            };

            if (YesNo && TempSoal.yes_no === 1) {
                formData.pilihan_id = YesNo;
            } else {
                formData.pilihan_id = PilihanId;
            }

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
                        SetYesNo(null);
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
        if (PilihanId === 0 && TempSoal.yes_no !== 1) {
            Swal.fire("Info!", "Pilih jawaban ", "info");
        } else if (!YesNo && TempSoal.yes_no === 1) {
            Swal.fire("Info!", "Pilih jawaban ya atau tidak", "info");
        } else {
            if (!FotoBersama) {
                Swal.fire(
                    "Info!",
                    "Silahkan Upload Bersama Responden ",
                    "info"
                );
            } else {
                SetLoadingUp(true);

                const formData = new FormData();

                formData.append("soal_id", TempSoal.id);
                formData.append("target_id", target.id);
                // formData.append("pilihan_id", PilihanId);
                formData.append("image", FotoBersama);
                // let formData = {
                //     soal_id: TempSoal.id,
                //     target_id: target.id,
                //     pilihan_id: PilihanId,
                // };
                // formData._token = csrf_token;

                if (YesNo && TempSoal.yes_no === 1) {
                    formData.append("pilihan_id", YesNo);
                } else {
                    formData.append("pilihan_id", PilihanId);
                }
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
                        console.log("err", err);
                        SetLoadingUp(false);
                        console.log("err", err);
                    });
            }
        }
    };

    const handleClickFile = () => {
        inputRef.current.click();
    };

    const handleChangeImage = (e) => {
        if (e.target.files.length) {
            SetFotoBersama(e.target.files[0]);

            const oFReader = new FileReader();
            oFReader.readAsDataURL(e.target.files[0]);

            oFReader.onload = function (oFREvent) {
                let imageSrc = oFREvent.target.result;
                SetPreviewImage(imageSrc);
            };
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

                SetYesNo(null);
            })
            .catch((err) => {
                SetLoadingUp(false);
                console.log("err", err);
                SetYesNo(null);
            });
    };

    const MultiplePilihan = () => {
        return (
            <>
                {TempSoal.pilihan.map((item, index) => {
                    return (
                        <div
                            className={`p-3 rounded-full mb-3 border flex items-center ${
                                PilihanId === item.id
                                    ? "bg-yellow-500 text-white  border-yellow-500 "
                                    : "bg-yellow-100 border-yellow-100"
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
                            <span className="mr-2 text-sm">{index + 1}.</span>
                            <span className="text-sm">{item.title}</span>
                        </div>
                    );
                })}
            </>
        );
    };

    return (
        <Layout>
            <Head title={`Pertanyaan ${TempSoal.title}`} />
            {/* Loading */}
            {LoadingUp && <LoadingPage />}
            {/* Loading end*/}
            <div className="bg-yellow-50 min-h-screen">
                <div className="bg-yellow-600 h-36 w-full rounded-b-3xl">
                    <Link
                        href="/list-survey"
                        className="flex items-center px-3 pt-2"
                    >
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
                        <div className="text-white ml-3">Survey</div>
                    </Link>
                </div>
                <div className="bg-white p-3 rounded-lg -mt-24 mx-3">
                    <div className="text-lg font-semibold">
                        {TempSoal.title}
                    </div>
                    <div className="text-sm">{TempSoal.subtitle}</div>
                </div>
                <div className="bg-white p-3 rounded-lg  mx-3 mt-2">
                    {TempSoal.yes_no > 0 ? (
                        <>
                            <div
                                className={`p-3 rounded-full mb-3 border flex items-center ${
                                    YesNo === "iya"
                                        ? "bg-yellow-500 text-white  border-yellow-500 "
                                        : "bg-yellow-100 border-yellow-100"
                                }`}
                                onClick={() => SetYesNo("iya")}
                            >
                                {YesNo === "iya" && (
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
                                <span className="mr-2 text-sm">1.</span>
                                <span className="text-sm">Iya</span>
                            </div>
                            <div
                                className={`p-3 rounded-full mb-3 border flex items-center ${
                                    YesNo === "tidak"
                                        ? "bg-yellow-500 text-white  border-yellow-500 "
                                        : "bg-yellow-100 border-yellow-100"
                                }`}
                                onClick={() => SetYesNo("tidak")}
                            >
                                {YesNo === "tidak" && (
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
                                <span className="mr-2 text-sm">2.</span>
                                <span className="text-sm">Tidak</span>
                            </div>
                        </>
                    ) : (
                        <MultiplePilihan />
                    )}
                    {TempLastSoal ? (
                        <>
                            <div
                                onClick={handleClickFile}
                                className="flex flex-col items-center justify-center h-32 w-full bg-gray-200 rounded-lg mt-6"
                            >
                                {PreviewImage ? (
                                    <img
                                        src={PreviewImage}
                                        alt=""
                                        className="h-32 mx-auto object-contain  text-center"
                                    />
                                ) : (
                                    <>
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
                                                    d="M6.827 6.175A2.31 2.31 0 015.186 7.23c-.38.054-.757.112-1.134.175C2.999 7.58 2.25 8.507 2.25 9.574V18a2.25 2.25 0 002.25 2.25h15A2.25 2.25 0 0021.75 18V9.574c0-1.067-.75-1.994-1.802-2.169a47.865 47.865 0 00-1.134-.175 2.31 2.31 0 01-1.64-1.055l-.822-1.316a2.192 2.192 0 00-1.736-1.039 48.774 48.774 0 00-5.232 0 2.192 2.192 0 00-1.736 1.039l-.821 1.316z"
                                                />
                                                <path
                                                    strokeLinecap="round"
                                                    strokeLinejoin="round"
                                                    d="M16.5 12.75a4.5 4.5 0 11-9 0 4.5 4.5 0 019 0zM18.75 10.5h.008v.008h-.008V10.5z"
                                                />
                                            </svg>
                                        </div>
                                        <div className="">Foto Bersama</div>
                                    </>
                                )}
                            </div>

                            <input
                                type="file"
                                ref={inputRef}
                                className=""
                                hidden
                                accept="image/*"
                                capture="camera"
                                onChange={handleChangeImage}
                            />
                            <div
                                onClick={handleSelesai}
                                className=" bg-yellow-600 text-white text-center px-2 py-3 rounded-full w-full mt-10"
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
                                className=" bg-yellow-600 text-white text-center px-2 py-3 rounded-full w-1/2"
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
