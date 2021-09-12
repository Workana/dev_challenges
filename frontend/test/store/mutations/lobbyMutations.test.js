import * as lobby from "frontend/src/store/modules/lobby.js"

describe("UPDATE_ISSUE", () => {
    it("should update the issue correctly", () => {
        const issue = { number: 1, userStatuses: [{status:"Voted",
                user:"Pepeee",
                vote:20
            }], status: 'Finished', avg: '8' }
        const state = {
            members: [],
            issue: null,
            issueStatus: '',
            avg: null,
        }

        lobby.default.mutations.UPDATE_ISSUE(state, issue);

        expect(state).toEqual({
            members: [{status:"Voted",
                user:"Pepeee",
                vote:20
            }],
            issue: 1,
            issueStatus: 'Finished',
            avg: '8',
        })
    })
})
