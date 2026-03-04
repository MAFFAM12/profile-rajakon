import React from 'react'

const Input = ({ inputKey, type = "text", label = "", errorMessage, ...props }) => {
    return (
        <div>
            <label htmlFor={inputKey} className="block text-sm font-medium text-gray-700 mb-2">
                {label}
            </label>
            <input
                type={type}
                id={inputKey}
                name={inputKey}
                className="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                {...props}
            />
            <span className='text-sm text-red-500'>{errorMessage}</span>
        </div>
    )
}

export default Input