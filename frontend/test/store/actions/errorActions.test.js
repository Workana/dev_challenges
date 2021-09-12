import * as error from "../../../src/store/modules/error";

describe("getIssue", () => {
    it("should commit SET_ERROR", async () => {
        const commit = jest.fn()
        const message = 'Error'

        await error.default.actions.setError({ commit }, message)

        expect(commit).toHaveBeenCalledWith(
            "SET_ERROR", message)
    })
})

describe("clearError", () => {
    it("should commit CLEAR_ERROR", async () => {
        const commit = jest.fn()

        await error.default.actions.clearError({ commit })

        expect(commit).toHaveBeenCalledWith("CLEAR_ERROR")
    })
})
