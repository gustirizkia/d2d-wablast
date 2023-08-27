import React, { useEffect, useRef, useState } from "react";
import Layout from "../../Layouts/User";
import { Head, Link } from "@inertiajs/react";
import LoadingQuiz from "./LoadingQuiz";
import axios from "axios";
import MulitplePilihan from "./MulitplePilihan";
import YesNo from "./YesNo";
import SubmitData from "./SubmitData";

export default function QuizIndex({ target, kecamatan }) {
    const [HideLoading, SetHideLoading] = useState(false);
    const [SoalGeneral, SetSoalGeneral] = useState([]);
    const [SoalKecamatan, SetSoalKecamatan] = useState([]);
    const [PilihanUser, SetPilihanUser] = useState([]);
    const [FotoBersama, SetFotoBersama] = useState(null);
    const [PreviewImage, SetPreviewImage] = useState(null);

    const inputRef = useRef(null);

    useEffect(() => {
        axios
            .get(`/api/all-quiz/${target.id}`)
            .then((ress) => {
                let dataObj = ress.data.soal_general;

                ress.data.soal_kecamatan.forEach((element) => {
                    dataObj.push(element);
                });

                SetSoalGeneral(dataObj);

                SetHideLoading(true);
            })
            .catch((err) => {
                console.log("err", err);
            });
    }, []);

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

    const handelPilihanYesNo = (pilihan, soal, type) => {
        let newData = [];
        let filterArray = null;
        if (soal.skip_soal) {
            SoalGeneral.map((el, index) => {
                newData.push(el);
                if (el.id === soal.id) {
                    if (
                        SoalGeneral[index + 1].skip_soal_id !== soal.id &&
                        soal.skip_soal?.skip_if_yes_no !== pilihan
                    ) {
                        newData.push(el.skip_soal);
                    } else {
                        if (SoalGeneral[index + 1].skip_soal_id === soal.id) {
                            if (soal.skip_soal?.skip_if_yes_no === pilihan) {
                                filterArray = SoalGeneral.filter(
                                    (item) => item.skip_soal_id !== soal.id
                                );
                            }
                        }
                    }
                }
            });

            if (filterArray) {
                SetSoalGeneral(filterArray);
            } else {
                SetSoalGeneral(newData);
            }
        }

        let formPiliihan = {
            soal_id: soal.id,
            pilihan_id: null,
            yes_no: pilihan,
        };

        let soal_id = null;
        PilihanUser.map((itemMap) => {
            if (itemMap.soal_id === soal.id) {
                soal_id = soal.id;
            }
        });

        if (soal_id) {
            let newData = PilihanUser.map((el) => {
                if (el.soal_id === soal_id) {
                    return { ...el, yes_no: pilihan };
                }

                return el;
            });

            newData.map((el, index) => {
                if (el.soal_id === soal.skip_soal?.skip_soal_id) {
                    if (pilihan === soal.skip_soal?.skip_if_yes_no) {
                        newData = newData.filter((item) => {
                            return item.soal_id !== soal.skip_soal?.id;
                        });
                    }
                }
            });

            SetPilihanUser(newData);
        } else {
            SetPilihanUser((PilihanUser) => [...PilihanUser, formPiliihan]);
        }
    };

    const handleSetPilihan = (pilihan, item, type) => {
        let newData = [];
        let filterArray = null;
        let soal = item;

        if (item.skip_soal) {
            console.log("item.skip_soal", item.skip_soal);
            SoalGeneral.map((el, index) => {
                newData.push(el);
                if (el.id === soal.id) {
                    if (
                        SoalGeneral[index + 1].skip_soal_id !== soal.id &&
                        soal.skip_soal?.skip_if_pilihan_id !== pilihan
                    ) {
                        newData.push(el.skip_soal);
                    } else {
                        if (SoalGeneral[index + 1].skip_soal_id === soal.id) {
                            if (
                                soal.skip_soal?.skip_if_pilihan_id === pilihan
                            ) {
                                filterArray = SoalGeneral.filter(
                                    (item) => item.skip_soal_id !== soal.id
                                );
                            }
                        }
                    }
                }
            });

            if (filterArray) {
                SetSoalGeneral(filterArray);
            } else {
                SetSoalGeneral(newData);
            }
        }

        let formPiliihan = {
            soal_id: item.id,
            pilihan_id: pilihan,
            yes_no: null,
        };

        let soal_id = null;
        PilihanUser.map((itemMap) => {
            if (itemMap.soal_id === item.id) {
                soal_id = item.id;
            }
        });

        if (soal_id) {
            let newData = PilihanUser.map((el) => {
                if (el.soal_id === soal_id) {
                    return { ...el, pilihan_id: pilihan };
                }

                return el;
            });

            let soal = item;

            newData.map((el, index) => {
                if (el.soal_id === soal.skip_soal?.skip_soal_id) {
                    if (pilihan === soal.skip_soal?.skip_if_pilihan_id) {
                        newData = newData.filter((itemData) => {
                            console.log("itemData", itemData);
                            return itemData.soal_id !== soal.skip_soal?.id;
                        });
                    }
                }
            });

            SetPilihanUser(newData);
        } else {
            SetPilihanUser((PilihanUser) => [...PilihanUser, formPiliihan]);
        }

        // end function
    };

    return (
        <Layout>
            <Head title="Mulai Survey" />
            <div className="bg-slate-200 min-h-screen">
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
                        <div className="text-white ml-3">
                            <div className="">Survey Kec. {kecamatan.nama}</div>
                        </div>
                    </Link>
                </div>
                <div className="px-3 -mt-24 pb-32">
                    {!HideLoading && <LoadingQuiz />}
                    {/* soal general  */}
                    {SoalGeneral.map((item) => {
                        return (
                            <div
                                className="bg-white rounded-lg p-3 mb-4"
                                key={item.id}
                            >
                                <div className="font-medium">{item.title}</div>
                                <div className="text-sm">{item.subtitle}</div>

                                <div className="mt-4">
                                    {item.yes_no > 0 ? (
                                        <YesNo
                                            TempSoal={item}
                                            callbackData={(
                                                pilihan,
                                                itemData
                                            ) => {
                                                handelPilihanYesNo(
                                                    pilihan,
                                                    itemData,
                                                    "general"
                                                );
                                            }}
                                        />
                                    ) : (
                                        <>
                                            <MulitplePilihan
                                                TempSoal={item}
                                                callBack={(
                                                    pilihan,
                                                    itemData
                                                ) => {
                                                    handleSetPilihan(
                                                        pilihan,
                                                        itemData,
                                                        "general"
                                                    );
                                                }}
                                            />
                                        </>
                                    )}
                                </div>
                            </div>
                        );
                    })}
                    {/* soal general end */}

                    {/* foto bersama */}
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
                        onClick={handleClickFile}
                        className="flex flex-col items-center justify-center h-32 w-full bg-white rounded-lg mt-6"
                    >
                        {PreviewImage ? (
                            <img
                                src={PreviewImage}
                                alt=""
                                className="h-32 mx-auto object-contain  text-center"
                            />
                        ) : (
                            <>
                                <div className="bg-yellow-600 text-white h-14 w-14 flex justify-center items-center rounded-full">
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
                                <div className="mt-2 text-sm">Foto Bersama</div>
                            </>
                        )}
                    </div>
                    {/* foto bersama end */}
                    <div className="mt-4">
                        <SubmitData
                            pilihan={PilihanUser}
                            soal={SoalGeneral}
                            foto={FotoBersama}
                            target_id={target.id}
                        />
                    </div>
                </div>
            </div>
        </Layout>
    );
}
