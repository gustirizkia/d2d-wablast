import React, { useEffect } from "react";

export default function TopUser({ auth }) {
    return (
        <div className="flex px-3 py-2 items-center">
            <img
                src={`https://ui-avatars.com/api/?name=${auth.user.name}`}
                alt=""
                className="h-8 w-8 object-cover rounded-full mr-2"
            />
            <div className="font-semibold text-sm text-white">
                {auth.user.name}
            </div>
        </div>
    );
}
