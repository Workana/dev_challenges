import * as error from "frontend/src/store/modules/error.js"

describe("SET_ERROR", () => {
    it("should set the error correctly", () => {
        const message = 'Some error';
        const state = {
            isError: false,
            message: '',
        }

        error.default.mutations.SET_ERROR(state, message);

        expect(state).toEqual({
            isError: true,
            message: 'Some error',
        })
    })
})

describe("CLEAR_ERROR", () => {
    it("should clear the error correctly", () => {
        const state = {
            isError: true,
            message: 'Some error',
        }

        error.default.mutations.CLEAR_ERROR(state);

        expect(state).toEqual({
            isError: false,
            message: '',
        })
    })
})
