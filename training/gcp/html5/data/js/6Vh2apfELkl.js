window.globalProvideData('slide', '{"title":"MULTIPLE CHOICE","trackViews":true,"showMenuResultIcon":false,"viewGroupId":"","historyGroupId":"","videoZoom":"","scrolling":false,"transition":"appear","transDuration":0,"transDir":1,"wipeTrans":false,"slideLock":false,"navIndex":-1,"globalAudioId":"","thumbnailid":"","presenterRef":{"id":"none"},"showAnimationId":"","lmsId":"Slide11","width":720,"height":540,"resume":true,"background":{"type":"fill","fill":{"type":"linear","rotation":90,"colors":[{"kind":"color","rgb":"0xFFFFFF","alpha":100,"stop":0}]}},"id":"6Vh2apfELkl","actionGroups":{"ActGrpOnSubmitButtonClick":{"kind":"actiongroup","actions":[{"kind":"if_action","condition":{"statement":{"kind":"or","statements":[{"kind":"compare","operator":"eq","valuea":"5fGN85FRWrn.60le7Q3gIs5.#_checked","typea":"var","valueb":true,"typeb":"boolean"},{"kind":"compare","operator":"eq","valuea":"5fGN85FRWrn.5VIgV0w9Ov5.#_checked","typea":"var","valueb":true,"typeb":"boolean"}]}},"thenActions":[{"kind":"eval_interaction","id":"_this.5erdsXubA0V"}],"elseActions":[{"kind":"gotoplay","window":"MessageWnd","wndtype":"normal","objRef":{"type":"string","value":"_player.MsgScene_5zkCJCn0tXZ.InvalidPromptSlide"}}]}]},"ReviewInt_5fGN85FRWrn":{"kind":"actiongroup","actions":[{"kind":"set_enabled","objRef":{"type":"string","value":"5fGN85FRWrn.60le7Q3gIs5"},"enabled":{"type":"boolean","value":false}},{"kind":"set_enabled","objRef":{"type":"string","value":"5fGN85FRWrn.5VIgV0w9Ov5"},"enabled":{"type":"boolean","value":false}},{"kind":"if_action","condition":{"statement":{"kind":"compare","operator":"eq","valuea":"5erdsXubA0V.$Status","typea":"property","valueb":"correct","typeb":"string"}},"thenActions":[{"kind":"show","transition":"appear","objRef":{"type":"string","value":"5fGN85FRWrn_CorrectReview"}}],"elseActions":[{"kind":"show","transition":"appear","objRef":{"type":"string","value":"5fGN85FRWrn_IncorrectReview"}}]}]},"ReviewIntCorrectIncorrect_5fGN85FRWrn":{"kind":"actiongroup","actions":[{"kind":"set_enabled","objRef":{"type":"string","value":"5fGN85FRWrn.60le7Q3gIs5"},"enabled":{"type":"boolean","value":false}},{"kind":"if_action","condition":{"statement":{"kind":"compare","operator":"eq","valuea":"5fGN85FRWrn.5VIgV0w9Ov5.$OnStage","typea":"property","valueb":false,"typeb":"boolean"}},"thenActions":[{"kind":"show","transition":"appear","objRef":{"type":"string","value":"5fGN85FRWrn.5VIgV0w9Ov5"}}]},{"kind":"adjustvar","variable":"5fGN85FRWrn.5VIgV0w9Ov5._hover","operator":"set","value":{"type":"boolean","value":false}},{"kind":"adjustvar","variable":"5fGN85FRWrn.5VIgV0w9Ov5._down","operator":"set","value":{"type":"boolean","value":false}},{"kind":"adjustvar","variable":"5fGN85FRWrn.5VIgV0w9Ov5._disabled","operator":"set","value":{"type":"boolean","value":false}},{"kind":"exe_actiongroup","id":"5fGN85FRWrn.5VIgV0w9Ov5.ActGrpSetReviewState"},{"kind":"set_enabled","objRef":{"type":"string","value":"5fGN85FRWrn.5VIgV0w9Ov5"},"enabled":{"type":"boolean","value":false}}]},"AnsweredInt_5fGN85FRWrn":{"kind":"actiongroup","actions":[{"kind":"exe_actiongroup","id":"DisableChoices_5fGN85FRWrn"},{"kind":"if_action","condition":{"statement":{"kind":"compare","operator":"eq","valuea":"$WindowId","typea":"property","valueb":"_frame","typeb":"string"}},"thenActions":[{"kind":"set_frame_layout","name":"pxabnsnfns00001000001"}],"elseActions":[{"kind":"set_window_control_layout","name":"pxabnsnfns00001000001"}]}]},"DisableChoices_5fGN85FRWrn":{"kind":"actiongroup","actions":[{"kind":"exe_actiongroup","id":"5fGN85FRWrn.60le7Q3gIs5.ActGrpSetDisabledState"},{"kind":"exe_actiongroup","id":"5fGN85FRWrn.5VIgV0w9Ov5.ActGrpSetDisabledState"}]},"5fGN85FRWrn_CheckAnswered":{"kind":"actiongroup","actions":[{"kind":"if_action","condition":{"statement":{"kind":"and","statements":[{"kind":"compare","operator":"eq","valuea":"_parent.$Id","typea":"property","valueb":"6liK9RpXnlH","typeb":"string"},{"kind":"or","statements":[{"kind":"compare","operator":"eq","valuea":"5erdsXubA0V.$Status","typea":"property","valueb":"correct","typeb":"string"},{"kind":"compare","operator":"eq","valuea":"_player.6SZXdLZVWqE.$QuizComplete","typea":"property","valueb":true,"typeb":"boolean"}]}]}},"thenActions":[{"kind":"exe_actiongroup","id":"AnsweredInt_5fGN85FRWrn"}],"elseActions":[{"kind":"if_action","condition":{"statement":{"kind":"compare","operator":"eq","valuea":"5erdsXubA0V.$Status","typea":"property","valueb":"incorrect","typeb":"string"}},"thenActions":[{"kind":"if_action","condition":{"statement":{"kind":"compare","operator":"gte","valuea":"5erdsXubA0V.$AttemptCount","typea":"property","valueb":1,"typeb":"number"}},"thenActions":[{"kind":"exe_actiongroup","id":"AnsweredInt_5fGN85FRWrn"}]}]}]}]},"SetLayout_pxabnsnfns00001000001":{"kind":"actiongroup","actions":[{"kind":"if_action","condition":{"statement":{"kind":"compare","operator":"eq","valuea":"$WindowId","typea":"property","valueb":"_frame","typeb":"string"}},"thenActions":[{"kind":"set_frame_layout","name":"pxabnsnfns00001000001"}],"elseActions":[{"kind":"set_window_control_layout","name":"pxabnsnfns00001000001"}]}]},"NavigationRestrictionNextSlide_6Vh2apfELkl":{"kind":"actiongroup","actions":[{"kind":"playnextdrawslide"}]},"NavigationRestrictionPreviousSlide_6Vh2apfELkl":{"kind":"actiongroup","actions":[{"kind":"history_prev"}]}},"events":[{"kind":"onbeforeslidein","actions":[{"kind":"if_action","condition":{"statement":{"kind":"compare","operator":"eq","valuea":"$WindowId","typea":"property","valueb":"_frame","typeb":"string"}},"thenActions":[{"kind":"set_frame_layout","name":"npnxnanbsnfns00001000001"}],"elseActions":[{"kind":"set_window_control_layout","name":"npnxnanbsnfns00001000001"}]}]},{"kind":"onsubmitslide","actions":[{"kind":"exe_actiongroup","id":"ActGrpOnSubmitButtonClick"}]},{"kind":"ontransitionin","actions":[{"kind":"adjustvar","variable":"_player.LastSlideViewed_5zkCJCn0tXZ","operator":"set","value":{"type":"string","value":"_player."}},{"kind":"adjustvar","variable":"_player.LastSlideViewed_5zkCJCn0tXZ","operator":"add","value":{"type":"property","value":"$AbsoluteId"}},{"kind":"if_action","condition":{"statement":{"kind":"compare","operator":"eq","valuea":"_parent.$Id","typea":"property","valueb":"6liK9RpXnlH","typeb":"string"}},"thenActions":[{"kind":"if_action","condition":{"statement":{"kind":"compare","operator":"eq","valuea":"_player.#ReviewMode_6liK9RpXnlH","typea":"var","valueb":true,"typeb":"boolean"}},"thenActions":[{"kind":"exe_actiongroup","id":"ReviewInt_5fGN85FRWrn"},{"kind":"if_action","condition":{"statement":{"kind":"compare","operator":"eq","valuea":"_player.#CurrentQuiz_6liK9RpXnlH","typea":"var","valueb":"6SZXdLZVWqE","typeb":"string"}},"thenActions":[{"kind":"exe_actiongroup","id":"SetLayout_pxabnsnfns00001000001"},{"kind":"if_action","condition":{"statement":{"kind":"compare","operator":"eq","valuea":"_player.6SZXdLZVWqE.$Passed","typea":"property","valueb":true,"typeb":"boolean"}},"thenActions":[{"kind":"exe_actiongroup","id":"ReviewIntCorrectIncorrect_5fGN85FRWrn"}]},{"kind":"if_action","condition":{"statement":{"kind":"compare","operator":"eq","valuea":"_player.6SZXdLZVWqE.$Passed","typea":"property","valueb":false,"typeb":"boolean"}},"thenActions":[{"kind":"exe_actiongroup","id":"ReviewIntCorrectIncorrect_5fGN85FRWrn"}]}]}],"elseActions":[{"kind":"exe_actiongroup","id":"5fGN85FRWrn_CheckAnswered"}]}]}]},{"kind":"onnextslide","actions":[{"kind":"if_action","condition":{"statement":{"kind":"compare","operator":"eq","valuea":"_player.#ReviewMode_6liK9RpXnlH","typea":"var","valueb":true,"typeb":"boolean"}},"thenActions":[{"kind":"playnextdrawslide"}],"elseActions":[{"kind":"exe_actiongroup","id":"NavigationRestrictionNextSlide_6Vh2apfELkl"}]}]},{"kind":"onprevslide","actions":[{"kind":"exe_actiongroup","id":"NavigationRestrictionPreviousSlide_6Vh2apfELkl"}]}],"slideLayers":[{"enableSeek":true,"enableReplay":true,"timeline":{"duration":5000,"events":[{"kind":"ontimelinetick","time":0,"actions":[{"kind":"show","transition":"appear","objRef":{"type":"string","value":"5fGN85FRWrn"}},{"kind":"show","transition":"appear","objRef":{"type":"string","value":"5fGN85FRWrn.5VIgV0w9Ov5"}},{"kind":"show","transition":"appear","objRef":{"type":"string","value":"5fGN85FRWrn.60le7Q3gIs5"}},{"kind":"show","transition":"appear","objRef":{"type":"string","value":"6huvYkC0stK"}},{"kind":"show","transition":"appear","objRef":{"type":"string","value":"5cs84uW6qZt"}},{"kind":"show","transition":"appear","objRef":{"type":"string","value":"5ib7CE1BXry"}},{"kind":"show","transition":"appear","objRef":{"type":"string","value":"6mi8l027vVA"}},{"kind":"show","transition":"appear","objRef":{"type":"string","value":"66Qxzm3oVgh"}},{"kind":"show","transition":"appear","objRef":{"type":"string","value":"6cbhe3azkDW"}},{"kind":"show","transition":"appear","objRef":{"type":"string","value":"5Ye4VFT5bLV"}}]}]},"objects":[{"kind":"vectorshape","rotation":0,"accType":"image","cliptobounds":false,"defaultAction":"","imagelib":[{"kind":"imagedata","assetId":0,"id":"01","url":"story_content/6EfEhDaPozi_80_DX1440_DY1440.swf","type":"normal","altText":"backgroundpolitico.png","width":1440,"height":1080,"mobiledx":0,"mobiledy":0}],"shapemaskId":"","xPos":0,"yPos":0,"tabIndex":0,"tabEnabled":true,"xOffset":0,"yOffset":0,"rotateXPos":360,"rotateYPos":270,"scaleX":100,"scaleY":100,"alpha":100,"depth":1,"scrolling":false,"shuffleLock":false,"data":{"hotlinkId":"","accState":0,"vectorData":{"left":0,"top":0,"right":720,"bottom":540,"altText":"backgroundpolitico.png","pngfb":false,"pr":{"l":"Lib","i":0}},"html5data":{"xPos":0,"yPos":0,"width":720,"height":540,"strokewidth":0}},"width":720,"height":540,"resume":true,"useHandCursor":true,"id":"5Ye4VFT5bLV"},{"kind":"vectorshape","rotation":0,"accType":"text","cliptobounds":false,"defaultAction":"","shapemaskId":"","xPos":0,"yPos":40,"tabIndex":3,"tabEnabled":true,"xOffset":0,"yOffset":0,"rotateXPos":16,"rotateYPos":11,"scaleX":100,"scaleY":100,"alpha":100,"depth":2,"scrolling":false,"shuffleLock":false,"data":{"hotlinkId":"","accState":0,"vectorData":{"left":0,"top":0,"right":32,"bottom":23,"altText":"Rectangle 17 1","pngfb":false,"pr":{"l":"Lib","i":24}},"html5data":{"xPos":-1,"yPos":-1,"width":33,"height":23,"strokewidth":0}},"width":32,"height":22,"resume":true,"useHandCursor":true,"id":"6cbhe3azkDW"},{"kind":"scrollarea","contentwidth":676,"contentheight":96,"objects":[{"kind":"shufflegroup","objects":[{"kind":"vectorshape","rotation":0,"accType":"radio","cliptobounds":false,"defaultAction":"onrelease","textLib":[{"kind":"textdata","uniqueId":"6eORYRb6YfZ_1868459895","id":"01","linkId":"txt__default_5VIgV0w9Ov5","type":"vectortext","xPos":0,"yPos":0,"width":0,"height":0,"shadowIndex":-1,"vectortext":{"left":0,"top":0,"right":78,"bottom":36,"pngfb":false,"pr":{"l":"Lib","i":1221}}}],"shapemaskId":"","xPos":24,"yPos":48,"tabIndex":9,"tabEnabled":true,"xOffset":0,"yOffset":0,"rotateXPos":326,"rotateYPos":24,"scaleX":100,"scaleY":100,"alpha":100,"depth":1,"scrolling":true,"shuffleLock":false,"data":{"hotlinkId":"","accState":0,"vectorData":{"left":-1,"top":-1,"right":652,"bottom":48,"altText":"False","pngfb":false,"pr":{"l":"Lib","i":1183}},"html5data":{"xPos":-1,"yPos":-1,"width":653,"height":49,"strokewidth":0}},"states":[{"kind":"state","name":"_default_Disabled","data":{"hotlinkId":"","accState":1,"vectorData":{"left":-1,"top":-1,"right":652,"bottom":48,"altText":"False","pngfb":false,"pr":{"l":"Lib","i":1183}},"html5data":{"xPos":-1,"yPos":-1,"width":653,"height":49,"strokewidth":3}}},{"kind":"state","name":"_default_Review","data":{"hotlinkId":"","accState":0,"vectorData":{"left":-9,"top":-1,"right":652,"bottom":48,"altText":"False","pngfb":false,"pr":{"l":"Lib","i":1189}},"html5data":{"xPos":-9,"yPos":-1,"width":661,"height":49,"strokewidth":3}}},{"kind":"state","name":"_default_Down","data":{"hotlinkId":"","accState":8,"vectorData":{"left":-1,"top":-1,"right":652,"bottom":48,"altText":"False","pngfb":false,"pr":{"l":"Lib","i":1183}},"html5data":{"xPos":-1,"yPos":-1,"width":653,"height":49,"strokewidth":3}}},{"kind":"state","name":"_default_Selected","data":{"hotlinkId":"","accState":16,"vectorData":{"left":-1,"top":-1,"right":652,"bottom":48,"altText":"False","pngfb":false,"pr":{"l":"Lib","i":1184}},"html5data":{"xPos":-1,"yPos":-1,"width":653,"height":49,"strokewidth":3}}},{"kind":"state","name":"_default_Selected_Disabled","data":{"hotlinkId":"","accState":17,"vectorData":{"left":-1,"top":-1,"right":652,"bottom":48,"altText":"False","pngfb":false,"pr":{"l":"Lib","i":1184}},"html5data":{"xPos":-1,"yPos":-1,"width":653,"height":49,"strokewidth":3}}},{"kind":"state","name":"_default_Selected_Review","data":{"hotlinkId":"","accState":16,"vectorData":{"left":-9,"top":-1,"right":652,"bottom":48,"altText":"False","pngfb":false,"pr":{"l":"Lib","i":1190}},"html5data":{"xPos":-9,"yPos":-1,"width":661,"height":49,"strokewidth":3}}},{"kind":"state","name":"_default_Down_Selected","data":{"hotlinkId":"","accState":24,"vectorData":{"left":-1,"top":-1,"right":652,"bottom":48,"altText":"False","pngfb":false,"pr":{"l":"Lib","i":1184}},"html5data":{"xPos":-1,"yPos":-1,"width":653,"height":49,"strokewidth":3}}},{"kind":"state","name":"_default_Hover","data":{"hotlinkId":"","accState":0,"vectorData":{"left":-1,"top":-1,"right":652,"bottom":48,"altText":"False","pngfb":false,"pr":{"l":"Lib","i":1185}},"html5data":{"xPos":-1,"yPos":-1,"width":653,"height":49,"strokewidth":3}}},{"kind":"state","name":"_default_Hover_Disabled","data":{"hotlinkId":"","accState":1,"vectorData":{"left":-1,"top":-1,"right":652,"bottom":48,"altText":"False","pngfb":false,"pr":{"l":"Lib","i":1185}},"html5data":{"xPos":-1,"yPos":-1,"width":653,"height":49,"strokewidth":3}}},{"kind":"state","name":"_default_Hover_Down","data":{"hotlinkId":"","accState":8,"vectorData":{"left":-1,"top":-1,"right":652,"bottom":48,"altText":"False","pngfb":false,"pr":{"l":"Lib","i":1185}},"html5data":{"xPos":-1,"yPos":-1,"width":653,"height":49,"strokewidth":3}}},{"kind":"state","name":"_default_Hover_Selected","data":{"hotlinkId":"","accState":16,"vectorData":{"left":-1,"top":-1,"right":652,"bottom":48,"altText":"False","pngfb":false,"pr":{"l":"Lib","i":1186}},"html5data":{"xPos":-1,"yPos":-1,"width":653,"height":49,"strokewidth":3}}},{"kind":"state","name":"_default_Hover_Selected_Disabled","data":{"hotlinkId":"","accState":17,"vectorData":{"left":-1,"top":-1,"right":652,"bottom":48,"altText":"False","pngfb":false,"pr":{"l":"Lib","i":1186}},"html5data":{"xPos":-1,"yPos":-1,"width":653,"height":49,"strokewidth":3}}},{"kind":"state","name":"_default_Hover_Down_Selected","data":{"hotlinkId":"","accState":24,"vectorData":{"left":-1,"top":-1,"right":652,"bottom":48,"altText":"False","pngfb":false,"pr":{"l":"Lib","i":1186}},"html5data":{"xPos":-1,"yPos":-1,"width":653,"height":49,"strokewidth":3}}}],"width":652,"height":48,"resume":true,"useHandCursor":true,"id":"5VIgV0w9Ov5","variables":[{"kind":"variable","name":"_hover","type":"boolean","value":false,"resume":true},{"kind":"variable","name":"_down","type":"boolean","value":false,"resume":true},{"kind":"variable","name":"_disabled","type":"boolean","value":false,"resume":true},{"kind":"variable","name":"_checked","type":"boolean","value":false,"resume":true},{"kind":"variable","name":"_review","type":"boolean","value":false,"resume":true},{"kind":"variable","name":"_state","type":"string","value":"_default","resume":true},{"kind":"variable","name":"_stateName","type":"string","value":"","resume":true},{"kind":"variable","name":"_tempStateName","type":"string","value":"","resume":false}],"actionGroups":{"ActGrpSetCheckedState":{"kind":"actiongroup","actions":[{"kind":"adjustvar","variable":"_checked","operator":"set","value":{"type":"boolean","value":true}},{"kind":"exe_actiongroup","id":"_player._setstates","scopeRef":{"type":"string","value":"_this"}},{"kind":"exe_actiongroup","id":"ActGrpUnchecked"}]},"ActGrpUnchecked":{"kind":"actiongroup","actions":[{"kind":"if_action","condition":{"statement":{"kind":"compare","operator":"eq","valuea":"_parent.60le7Q3gIs5.#_checked","typea":"var","valueb":true,"typeb":"boolean"}},"thenActions":[{"kind":"adjustvar","variable":"_parent.60le7Q3gIs5._checked","operator":"set","value":{"type":"boolean","value":false}},{"kind":"exe_actiongroup","id":"_player._setstates","scopeRef":{"type":"string","value":"_parent.60le7Q3gIs5"}}]}]},"ActGrpSetHoverState":{"kind":"actiongroup","actions":[{"kind":"adjustvar","variable":"_hover","operator":"set","value":{"type":"boolean","value":true}},{"kind":"exe_actiongroup","id":"_player._setstates","scopeRef":{"type":"string","value":"_this"}}]},"ActGrpClearHoverState":{"kind":"actiongroup","actions":[{"kind":"adjustvar","variable":"_hover","operator":"set","value":{"type":"boolean","value":false}},{"kind":"exe_actiongroup","id":"_player._setstates","scopeRef":{"type":"string","value":"_this"}}]},"ActGrpSetDisabledState":{"kind":"actiongroup","actions":[{"kind":"adjustvar","variable":"_disabled","operator":"set","value":{"type":"boolean","value":true}},{"kind":"exe_actiongroup","id":"_player._setstates","scopeRef":{"type":"string","value":"_this"}}]},"ActGrpSetDownState":{"kind":"actiongroup","actions":[{"kind":"adjustvar","variable":"_down","operator":"set","value":{"type":"boolean","value":true}},{"kind":"exe_actiongroup","id":"_player._setstates","scopeRef":{"type":"string","value":"_this"}}]},"ActGrpSetReviewState":{"kind":"actiongroup","actions":[{"kind":"adjustvar","variable":"_review","operator":"set","value":{"type":"boolean","value":true}},{"kind":"exe_actiongroup","id":"_player._setstates","scopeRef":{"type":"string","value":"_this"}}]},"ActGrpClearStateVars":{"kind":"actiongroup","actions":[{"kind":"adjustvar","variable":"_hover","operator":"set","value":{"type":"boolean","value":false}},{"kind":"adjustvar","variable":"_down","operator":"set","value":{"type":"boolean","value":false}},{"kind":"adjustvar","variable":"_disabled","operator":"set","value":{"type":"boolean","value":false}},{"kind":"adjustvar","variable":"_checked","operator":"set","value":{"type":"boolean","value":false}},{"kind":"adjustvar","variable":"_review","operator":"set","value":{"type":"boolean","value":false}}]}},"events":[{"kind":"ontransitionin","actions":[{"kind":"exe_actiongroup","id":"_player._setstates","scopeRef":{"type":"string","value":"_this"}}]},{"kind":"onrollover","actions":[{"kind":"exe_actiongroup","id":"ActGrpSetHoverState","scopeRef":{"type":"string","value":"_this"}}]},{"kind":"onrollout","actions":[{"kind":"exe_actiongroup","id":"ActGrpClearHoverState","scopeRef":{"type":"string","value":"_this"}}]},{"kind":"onpress","actions":[{"kind":"exe_actiongroup","id":"ActGrpSetDownState","scopeRef":{"type":"string","value":"_this"}}]},{"kind":"onrelease","actions":[{"kind":"exe_actiongroup","id":"ActGrpUnchecked"},{"kind":"adjustvar","variable":"_checked","operator":"set","value":{"type":"boolean","value":true}},{"kind":"adjustvar","variable":"_down","operator":"set","value":{"type":"boolean","value":false}},{"kind":"exe_actiongroup","id":"_player._setstates","scopeRef":{"type":"string","value":"_this"}}]},{"kind":"onreleaseoutside","actions":[{"kind":"adjustvar","variable":"_down","operator":"set","value":{"type":"boolean","value":false}},{"kind":"exe_actiongroup","id":"_player._setstates","scopeRef":{"type":"string","value":"_this"}}]}]},{"kind":"vectorshape","rotation":0,"accType":"radio","cliptobounds":false,"defaultAction":"onrelease","textLib":[{"kind":"textdata","uniqueId":"5iqrE8i6EMk_-500134292","id":"01","linkId":"txt__default_60le7Q3gIs5","type":"vectortext","xPos":0,"yPos":0,"width":0,"height":0,"shadowIndex":-1,"vectortext":{"left":0,"top":0,"right":73,"bottom":36,"pngfb":false,"pr":{"l":"Lib","i":1222}}}],"shapemaskId":"","xPos":24,"yPos":0,"tabIndex":8,"tabEnabled":true,"xOffset":0,"yOffset":0,"rotateXPos":326,"rotateYPos":24,"scaleX":100,"scaleY":100,"alpha":100,"depth":2,"scrolling":true,"shuffleLock":false,"data":{"hotlinkId":"","accState":0,"vectorData":{"left":-1,"top":-1,"right":652,"bottom":48,"altText":"True","pngfb":false,"pr":{"l":"Lib","i":1183}},"html5data":{"xPos":-1,"yPos":-1,"width":653,"height":49,"strokewidth":0}},"states":[{"kind":"state","name":"_default_Disabled","data":{"hotlinkId":"","accState":1,"vectorData":{"left":-1,"top":-1,"right":652,"bottom":48,"altText":"True","pngfb":false,"pr":{"l":"Lib","i":1183}},"html5data":{"xPos":-1,"yPos":-1,"width":653,"height":49,"strokewidth":3}}},{"kind":"state","name":"_default_Down","data":{"hotlinkId":"","accState":8,"vectorData":{"left":-1,"top":-1,"right":652,"bottom":48,"altText":"True","pngfb":false,"pr":{"l":"Lib","i":1183}},"html5data":{"xPos":-1,"yPos":-1,"width":653,"height":49,"strokewidth":3}}},{"kind":"state","name":"_default_Selected","data":{"hotlinkId":"","accState":16,"vectorData":{"left":-1,"top":-1,"right":652,"bottom":48,"altText":"True","pngfb":false,"pr":{"l":"Lib","i":1184}},"html5data":{"xPos":-1,"yPos":-1,"width":653,"height":49,"strokewidth":3}}},{"kind":"state","name":"_default_Selected_Disabled","data":{"hotlinkId":"","accState":17,"vectorData":{"left":-1,"top":-1,"right":652,"bottom":48,"altText":"True","pngfb":false,"pr":{"l":"Lib","i":1184}},"html5data":{"xPos":-1,"yPos":-1,"width":653,"height":49,"strokewidth":3}}},{"kind":"state","name":"_default_Down_Selected","data":{"hotlinkId":"","accState":24,"vectorData":{"left":-1,"top":-1,"right":652,"bottom":48,"altText":"True","pngfb":false,"pr":{"l":"Lib","i":1184}},"html5data":{"xPos":-1,"yPos":-1,"width":653,"height":49,"strokewidth":3}}},{"kind":"state","name":"_default_Hover","data":{"hotlinkId":"","accState":0,"vectorData":{"left":-1,"top":-1,"right":652,"bottom":48,"altText":"True","pngfb":false,"pr":{"l":"Lib","i":1185}},"html5data":{"xPos":-1,"yPos":-1,"width":653,"height":49,"strokewidth":3}}},{"kind":"state","name":"_default_Hover_Disabled","data":{"hotlinkId":"","accState":1,"vectorData":{"left":-1,"top":-1,"right":652,"bottom":48,"altText":"True","pngfb":false,"pr":{"l":"Lib","i":1185}},"html5data":{"xPos":-1,"yPos":-1,"width":653,"height":49,"strokewidth":3}}},{"kind":"state","name":"_default_Hover_Down","data":{"hotlinkId":"","accState":8,"vectorData":{"left":-1,"top":-1,"right":652,"bottom":48,"altText":"True","pngfb":false,"pr":{"l":"Lib","i":1185}},"html5data":{"xPos":-1,"yPos":-1,"width":653,"height":49,"strokewidth":3}}},{"kind":"state","name":"_default_Hover_Selected","data":{"hotlinkId":"","accState":16,"vectorData":{"left":-1,"top":-1,"right":652,"bottom":48,"altText":"True","pngfb":false,"pr":{"l":"Lib","i":1186}},"html5data":{"xPos":-1,"yPos":-1,"width":653,"height":49,"strokewidth":3}}},{"kind":"state","name":"_default_Hover_Selected_Disabled","data":{"hotlinkId":"","accState":17,"vectorData":{"left":-1,"top":-1,"right":652,"bottom":48,"altText":"True","pngfb":false,"pr":{"l":"Lib","i":1186}},"html5data":{"xPos":-1,"yPos":-1,"width":653,"height":49,"strokewidth":3}}},{"kind":"state","name":"_default_Hover_Down_Selected","data":{"hotlinkId":"","accState":24,"vectorData":{"left":-1,"top":-1,"right":652,"bottom":48,"altText":"True","pngfb":false,"pr":{"l":"Lib","i":1186}},"html5data":{"xPos":-1,"yPos":-1,"width":653,"height":49,"strokewidth":3}}}],"width":652,"height":48,"resume":true,"useHandCursor":true,"id":"60le7Q3gIs5","variables":[{"kind":"variable","name":"_hover","type":"boolean","value":false,"resume":true},{"kind":"variable","name":"_down","type":"boolean","value":false,"resume":true},{"kind":"variable","name":"_disabled","type":"boolean","value":false,"resume":true},{"kind":"variable","name":"_checked","type":"boolean","value":false,"resume":true},{"kind":"variable","name":"_state","type":"string","value":"_default","resume":true},{"kind":"variable","name":"_stateName","type":"string","value":"","resume":true},{"kind":"variable","name":"_tempStateName","type":"string","value":"","resume":false}],"actionGroups":{"ActGrpSetCheckedState":{"kind":"actiongroup","actions":[{"kind":"adjustvar","variable":"_checked","operator":"set","value":{"type":"boolean","value":true}},{"kind":"exe_actiongroup","id":"_player._setstates","scopeRef":{"type":"string","value":"_this"}},{"kind":"exe_actiongroup","id":"ActGrpUnchecked"}]},"ActGrpUnchecked":{"kind":"actiongroup","actions":[{"kind":"if_action","condition":{"statement":{"kind":"compare","operator":"eq","valuea":"_parent.5VIgV0w9Ov5.#_checked","typea":"var","valueb":true,"typeb":"boolean"}},"thenActions":[{"kind":"adjustvar","variable":"_parent.5VIgV0w9Ov5._checked","operator":"set","value":{"type":"boolean","value":false}},{"kind":"exe_actiongroup","id":"_player._setstates","scopeRef":{"type":"string","value":"_parent.5VIgV0w9Ov5"}}]}]},"ActGrpSetHoverState":{"kind":"actiongroup","actions":[{"kind":"adjustvar","variable":"_hover","operator":"set","value":{"type":"boolean","value":true}},{"kind":"exe_actiongroup","id":"_player._setstates","scopeRef":{"type":"string","value":"_this"}}]},"ActGrpClearHoverState":{"kind":"actiongroup","actions":[{"kind":"adjustvar","variable":"_hover","operator":"set","value":{"type":"boolean","value":false}},{"kind":"exe_actiongroup","id":"_player._setstates","scopeRef":{"type":"string","value":"_this"}}]},"ActGrpSetDisabledState":{"kind":"actiongroup","actions":[{"kind":"adjustvar","variable":"_disabled","operator":"set","value":{"type":"boolean","value":true}},{"kind":"exe_actiongroup","id":"_player._setstates","scopeRef":{"type":"string","value":"_this"}}]},"ActGrpSetDownState":{"kind":"actiongroup","actions":[{"kind":"adjustvar","variable":"_down","operator":"set","value":{"type":"boolean","value":true}},{"kind":"exe_actiongroup","id":"_player._setstates","scopeRef":{"type":"string","value":"_this"}}]},"ActGrpClearStateVars":{"kind":"actiongroup","actions":[{"kind":"adjustvar","variable":"_hover","operator":"set","value":{"type":"boolean","value":false}},{"kind":"adjustvar","variable":"_down","operator":"set","value":{"type":"boolean","value":false}},{"kind":"adjustvar","variable":"_disabled","operator":"set","value":{"type":"boolean","value":false}},{"kind":"adjustvar","variable":"_checked","operator":"set","value":{"type":"boolean","value":false}}]}},"events":[{"kind":"ontransitionin","actions":[{"kind":"exe_actiongroup","id":"_player._setstates","scopeRef":{"type":"string","value":"_this"}}]},{"kind":"onrollover","actions":[{"kind":"exe_actiongroup","id":"ActGrpSetHoverState","scopeRef":{"type":"string","value":"_this"}}]},{"kind":"onrollout","actions":[{"kind":"exe_actiongroup","id":"ActGrpClearHoverState","scopeRef":{"type":"string","value":"_this"}}]},{"kind":"onpress","actions":[{"kind":"exe_actiongroup","id":"ActGrpSetDownState","scopeRef":{"type":"string","value":"_this"}}]},{"kind":"onrelease","actions":[{"kind":"exe_actiongroup","id":"ActGrpUnchecked"},{"kind":"adjustvar","variable":"_checked","operator":"set","value":{"type":"boolean","value":true}},{"kind":"adjustvar","variable":"_down","operator":"set","value":{"type":"boolean","value":false}},{"kind":"exe_actiongroup","id":"_player._setstates","scopeRef":{"type":"string","value":"_this"}}]},{"kind":"onreleaseoutside","actions":[{"kind":"adjustvar","variable":"_down","operator":"set","value":{"type":"boolean","value":false}},{"kind":"exe_actiongroup","id":"_player._setstates","scopeRef":{"type":"string","value":"_this"}}]}]}],"shuffle":false,"shapemaskId":"","xPos":0,"yPos":0,"tabIndex":-1,"tabEnabled":true,"xOffset":0,"yOffset":0,"rotateXPos":0,"rotateYPos":0,"scaleX":100,"scaleY":100,"alpha":100,"rotation":0,"depth":1,"scrolling":true,"shuffleLock":false,"width":0,"height":0,"resume":false,"useHandCursor":true,"id":""}],"shapemaskId":"","xPos":25,"yPos":252,"tabIndex":7,"tabEnabled":false,"xOffset":0,"yOffset":0,"rotateXPos":326,"rotateYPos":109,"scaleX":100,"scaleY":100,"alpha":100,"rotation":0,"depth":3,"scrolling":true,"shuffleLock":false,"data":{"hotlinkId":"","accState":0,"html5data":{"url":"","xPos":49,"yPos":252,"width":652,"height":218,"strokewidth":0}},"width":676,"height":218,"resume":true,"useHandCursor":true,"background":{"type":"vector","vectorData":{"left":0,"top":0,"right":676,"bottom":218,"altText":"Multiple Choice","pngfb":false,"pr":{"l":"Lib","i":1182}}},"id":"5fGN85FRWrn"},{"kind":"vectorshape","rotation":0,"accType":"text","cliptobounds":false,"defaultAction":"","textLib":[{"kind":"textdata","uniqueId":"6huvYkC0stK_-332305226","id":"01","linkId":"txt__default_6huvYkC0stK","type":"vectortext","xPos":0,"yPos":0,"width":0,"height":0,"shadowIndex":-1,"vectortext":{"left":0,"top":0,"right":620,"bottom":53,"pngfb":false,"pr":{"l":"Lib","i":1263}}}],"shapemaskId":"","xPos":49,"yPos":168,"tabIndex":6,"tabEnabled":true,"xOffset":0,"yOffset":0,"rotateXPos":326,"rotateYPos":37,"scaleX":100,"scaleY":100,"alpha":100,"depth":4,"scrolling":true,"shuffleLock":false,"data":{"hotlinkId":"","accState":0,"vectorData":{"left":0,"top":0,"right":652,"bottom":74,"altText":"The Declaration of Helsinki has been adopted into law in several countries, in conjunction with ICH GCP.","pngfb":false,"pr":{"l":"Lib","i":1193}},"html5data":{"xPos":-1,"yPos":-1,"width":653,"height":75,"strokewidth":0}},"width":652,"height":74,"resume":true,"useHandCursor":true,"id":"6huvYkC0stK"},{"kind":"vectorshape","rotation":0,"accType":"text","cliptobounds":false,"defaultAction":"","shapemaskId":"","xPos":0,"yPos":110,"tabIndex":4,"tabEnabled":true,"xOffset":0,"yOffset":0,"rotateXPos":360,"rotateYPos":20,"scaleX":100,"scaleY":100,"alpha":100,"depth":5,"scrolling":true,"shuffleLock":false,"data":{"hotlinkId":"","accState":0,"vectorData":{"left":0,"top":0,"right":720,"bottom":40,"altText":"Rectangle","pngfb":false,"pr":{"l":"Lib","i":1195}},"html5data":{"xPos":-1,"yPos":-1,"width":721,"height":41,"strokewidth":0}},"width":720,"height":40,"resume":true,"useHandCursor":true,"id":"5cs84uW6qZt"},{"kind":"vectorshape","rotation":0,"accType":"text","cliptobounds":false,"defaultAction":"","textLib":[{"kind":"textdata","uniqueId":"5ib7CE1BXry_-1812466719","id":"01","linkId":"txt__default_5ib7CE1BXry","type":"vectortext","xPos":0,"yPos":0,"width":0,"height":0,"shadowIndex":-1,"vectortext":{"left":0,"top":0,"right":120,"bottom":28,"pngfb":false,"pr":{"l":"Lib","i":1197}}}],"shapemaskId":"","xPos":48,"yPos":114,"tabIndex":5,"tabEnabled":true,"xOffset":0,"yOffset":0,"rotateXPos":84,"rotateYPos":16.5,"scaleX":100,"scaleY":100,"alpha":100,"depth":6,"scrolling":true,"shuffleLock":false,"data":{"hotlinkId":"","accState":0,"vectorData":{"left":0,"top":0,"right":168,"bottom":33,"altText":"Quiz Question","pngfb":false,"pr":{"l":"Lib","i":1196}},"html5data":{"xPos":-1,"yPos":-1,"width":169,"height":34,"strokewidth":0}},"width":168,"height":33,"resume":true,"useHandCursor":true,"id":"5ib7CE1BXry"},{"kind":"vectorshape","rotation":0,"accType":"text","cliptobounds":false,"defaultAction":"","textLib":[{"kind":"textdata","uniqueId":"6mi8l027vVA_187014548","id":"01","linkId":"txt__default_6mi8l027vVA","type":"vectortext","xPos":0,"yPos":0,"width":0,"height":0,"shadowIndex":-1,"vectortext":{"left":0,"top":0,"right":262,"bottom":69,"pngfb":false,"pr":{"l":"Lib","i":1199}}}],"shapemaskId":"","xPos":47,"yPos":34,"tabIndex":1,"tabEnabled":true,"xOffset":0,"yOffset":0,"rotateXPos":327,"rotateYPos":45,"scaleX":100,"scaleY":100,"alpha":100,"depth":7,"scrolling":true,"shuffleLock":false,"data":{"hotlinkId":"","accState":0,"vectorData":{"left":0,"top":0,"right":654,"bottom":90,"altText":"MULTIPLE CHOICE","pngfb":false,"pr":{"l":"Lib","i":1198}},"html5data":{"xPos":-1,"yPos":-1,"width":655,"height":91,"strokewidth":0}},"width":654,"height":90,"resume":true,"useHandCursor":true,"id":"6mi8l027vVA"},{"kind":"vectorshape","rotation":0,"accType":"text","cliptobounds":false,"defaultAction":"","textLib":[{"kind":"textdata","uniqueId":"66Qxzm3oVgh_1984043497","id":"01","linkId":"txt__default_66Qxzm3oVgh","type":"vectortext","xPos":0,"yPos":0,"width":0,"height":0,"shadowIndex":-1,"vectortext":{"left":0,"top":0,"right":213,"bottom":29,"pngfb":false,"pr":{"l":"Lib","i":1201}}}],"shapemaskId":"","xPos":48,"yPos":34,"tabIndex":2,"tabEnabled":true,"xOffset":0,"yOffset":0,"rotateXPos":111.5,"rotateYPos":17,"scaleX":100,"scaleY":100,"alpha":100,"depth":8,"scrolling":true,"shuffleLock":false,"data":{"hotlinkId":"","accState":0,"vectorData":{"left":0,"top":0,"right":223,"bottom":34,"altText":"Good Clinical Practice- ICH E6","pngfb":false,"pr":{"l":"Lib","i":1200}},"html5data":{"xPos":-1,"yPos":-1,"width":224,"height":35,"strokewidth":0}},"width":223,"height":34,"resume":true,"useHandCursor":true,"id":"66Qxzm3oVgh"},{"kind":"vectorshape","rotation":0,"accType":"text","cliptobounds":false,"defaultAction":"","textLib":[{"kind":"textdata","uniqueId":"5fGN85FRWrn_CorrectReview","id":"01","linkId":"5fGN85FRWrn_CorrectReview","type":"vectortext","xPos":0,"yPos":0,"width":0,"height":0,"shadowIndex":-1,"vectortext":{"left":0,"top":0,"right":400,"bottom":37,"pngfb":false,"pr":{"l":"Lib","i":1203}}}],"shapemaskId":"","xPos":0,"yPos":500,"tabIndex":10,"tabEnabled":true,"xOffset":0,"yOffset":0,"rotateXPos":360,"rotateYPos":20,"scaleX":100,"scaleY":100,"alpha":100,"depth":9,"scrolling":true,"shuffleLock":false,"data":{"hotlinkId":"","accState":0,"vectorData":{"left":-1,"top":-1,"right":720,"bottom":40,"altText":"Correct","pngfb":false,"pr":{"l":"Lib","i":1202}},"html5data":{"xPos":1,"yPos":1,"width":717,"height":37,"strokewidth":2}},"width":720,"height":40,"resume":false,"useHandCursor":true,"id":"5fGN85FRWrn_CorrectReview","events":[{"kind":"onrelease","actions":[{"kind":"hide","transition":"appear","objRef":{"type":"string","value":"_this"}}]}]},{"kind":"vectorshape","rotation":0,"accType":"text","cliptobounds":false,"defaultAction":"","textLib":[{"kind":"textdata","uniqueId":"5fGN85FRWrn_IncorrectReview","id":"01","linkId":"5fGN85FRWrn_IncorrectReview","type":"vectortext","xPos":0,"yPos":0,"width":0,"height":0,"shadowIndex":-1,"vectortext":{"left":0,"top":0,"right":409,"bottom":37,"pngfb":false,"pr":{"l":"Lib","i":1205}}}],"shapemaskId":"","xPos":0,"yPos":500,"tabIndex":11,"tabEnabled":true,"xOffset":0,"yOffset":0,"rotateXPos":360,"rotateYPos":20,"scaleX":100,"scaleY":100,"alpha":100,"depth":10,"scrolling":true,"shuffleLock":false,"data":{"hotlinkId":"","accState":0,"vectorData":{"left":-1,"top":-1,"right":720,"bottom":40,"altText":"Incorrect","pngfb":false,"pr":{"l":"Lib","i":1204}},"html5data":{"xPos":1,"yPos":1,"width":717,"height":37,"strokewidth":2}},"width":720,"height":40,"resume":false,"useHandCursor":true,"id":"5fGN85FRWrn_IncorrectReview","events":[{"kind":"onrelease","actions":[{"kind":"hide","transition":"appear","objRef":{"type":"string","value":"_this"}}]}]}],"startTime":-1,"elapsedTimeMode":"normal","useHandCursor":false,"resume":true,"kind":"slidelayer","isBaseLayer":true}]}');